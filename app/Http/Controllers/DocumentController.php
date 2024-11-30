<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocumentBody;
use App\Models\DocumentHeader;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DocumentController extends Controller
{

    public function show($id)
    {
        $header = DocumentHeader::findOrFail($id);
        $body = DocumentBody::where('document_id', $id)->firstOrFail();

        $decryptedHeader = Crypt::decryptString($header->encryption_key);
        $decryptedBody = Crypt::decryptString($body->encrypted_body);

        if (hash('sha256', $decryptedBody) !== $body->checksum) {
            throw new \Exception('Data integrity compromised.');
        }

        return response()->json([
            'header' => htmlspecialchars($decryptedHeader, ENT_QUOTES, 'UTF-8'),
            'body' => htmlspecialchars($decryptedBody, ENT_QUOTES, 'UTF-8'),
        ]);
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'header' => 'required|string',
            'body' => 'required|string',
            'module' => 'required|string|exists:modules,name',
            'metadata' => 'nullable|array',
        ]);
        $module = Module::where('name', $validated['module'])->firstOrFail();
        //TODO handle config for each module
        $config = config('modules.'.lcfirst($module->name));
        $encryptionKey = $config['encryption_key']; // Retrieve the encryption key
        $encryptedHeader = Crypt::encryptString($validated['header']);
        $encryptedBody = Crypt::encryptString($validated['body']);
        $checksum = hash('sha256', $validated['body']);

        $header = DocumentHeader::create([
            'user_id' => 1,
            'module' => $request->module,
            'version' => 'v1.0',
            'metadata' => json_encode($request->metadata),
            'encryption_key' => Crypt::encryptString($encryptionKey)??'default_encryption_key',
        ]);

        DocumentBody::create([
            'document_id' => $header->id,
            'encrypted_body' => $encryptedBody,
            'checksum' => $checksum,
        ]);

        return response()->json(['message' => 'Document stored successfully.']);
    }
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'nullable|string',
            'module' => 'nullable|string',
            'tags' => 'nullable|array',
        ]);

        $query = DocumentHeader::query();

        // Apply filters
        if (!empty($validated['query'])) {
            $query->where('metadata', 'like', '%' . $validated['query'] . '%');
        }
        if (!empty($validated['module'])) {
            $query->where('module', $validated['module']);
        }
        if (!empty($validated['tags'])) {
            $query->whereJsonContains('metadata->tags', $validated['tags']);
        }

        $documents = $query->get(['id', 'module', 'metadata']);

        return response()->json($documents);
    }


    public function versions($id)
    {
        $document = DocumentHeader::with('versions')->findOrFail($id);

        return response()->json($document->versions);
    }

    public function destroy($id)
    {
        $document = DocumentHeader::findOrFail($id);
        if (auth('sanctum')->user()->cannot('delete', $document)){
            return response()->json([
                'message' => 'You don\'t have permission to delete this document'
            ]);
        }
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully.']);
    }
}

