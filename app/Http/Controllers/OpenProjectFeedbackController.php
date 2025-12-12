<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class OpenProjectFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'url' => 'nullable|url',
            'screenshot' => 'nullable|image|max:5120',
        ]);

        try {
            $openProjectUrl = config('openproject-feedback.openproject.url');
            $apiKey = config('openproject-feedback.openproject.api_key');
            $projectId = config('openproject-feedback.openproject.project_id');
            $typeName = config('openproject-feedback.openproject.type_name', 'Bug');
            $statusName = config('openproject-feedback.openproject.status_name', 'New');

            if (!$openProjectUrl || !$apiKey || !$projectId) {
                return response()->json([
                    'success' => false,
                    'message' => 'OpenProject configuration is missing'
                ], 500);
            }

            // Get type ID
            $typeId = config('openproject-feedback.openproject.type_id');
            if (!$typeId) {
                $typesResponse = Http::withBasicAuth('apikey', $apiKey)
                    ->get("{$openProjectUrl}/api/v3/types");
                
                if ($typesResponse->successful()) {
                    $types = $typesResponse->json('_embedded.elements', []);
                    $type = collect($types)->firstWhere('name', $typeName);
                    $typeId = $type['id'] ?? null;
                }
            }

            // Get status ID
            $statusesResponse = Http::withBasicAuth('apikey', $apiKey)
                ->get("{$openProjectUrl}/api/v3/statuses");
            
            $statusId = null;
            if ($statusesResponse->successful()) {
                $statuses = $statusesResponse->json('_embedded.elements', []);
                $status = collect($statuses)->firstWhere('name', $statusName);
                $statusId = $status['id'] ?? null;
            }

            // Prepare work package data
            $workPackageData = [
                'subject' => $request->input('subject'),
                'description' => [
                    'format' => 'plain',
                    'raw' => $request->input('description')
                ],
                '_links' => [
                    'type' => ['href' => "/api/v3/types/{$typeId}"],
                    'project' => ['href' => "/api/v3/projects/{$projectId}"],
                ]
            ];

            if ($statusId) {
                $workPackageData['_links']['status'] = ['href' => "/api/v3/statuses/{$statusId}"];
            }

            // Add priority if configured
            $priorityId = config('openproject-feedback.openproject.priority_id');
            if ($priorityId) {
                $workPackageData['_links']['priority'] = ['href' => "/api/v3/priorities/{$priorityId}"];
            }

            // Add assignee if configured
            $assigneeId = config('openproject-feedback.openproject.assignee_id');
            if ($assigneeId) {
                $workPackageData['_links']['assignee'] = ['href' => "/api/v3/users/{$assigneeId}"];
            }

            // Add URL as custom field or in description
            if ($request->input('url')) {
                $workPackageData['description']['raw'] .= "\n\nURL: " . $request->input('url');
            }

            // Create work package
            $response = Http::withBasicAuth('apikey', $apiKey)
                ->post("{$openProjectUrl}/api/v3/work_packages", $workPackageData);

            if ($response->successful()) {
                $workPackage = $response->json();

                // Handle screenshot if provided
                if ($request->hasFile('screenshot')) {
                    $screenshot = $request->file('screenshot');
                    // Upload attachment to the work package
                    $attachmentResponse = Http::withBasicAuth('apikey', $apiKey)
                        ->attach('file', file_get_contents($screenshot->getRealPath()), $screenshot->getClientOriginalName())
                        ->post("{$openProjectUrl}/api/v3/work_packages/{$workPackage['id']}/attachments", [
                            'fileName' => $screenshot->getClientOriginalName(),
                            'description' => 'Screenshot from feedback form'
                        ]);
                }

                // Log if enabled
                if (config('openproject-feedback.logging.enabled', true)) {
                    Log::channel(config('openproject-feedback.logging.channel', 'daily'))
                        ->info('Feedback submitted', [
                            'work_package_id' => $workPackage['id'],
                            'user_id' => auth()->id(),
                            'subject' => $request->input('subject'),
                        ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Feedback submitted successfully',
                    'work_package_id' => $workPackage['id']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit feedback to OpenProject',
                    'error' => $response->json()
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Feedback submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting feedback'
            ], 500);
        }
    }
}
