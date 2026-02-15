<?php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Show contact form (Public)
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission (Public)
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'name.required'    => 'Please enter your name.',
            'email.required'   => 'Please enter your email address.',
            'email.email'      => 'Please enter a valid email address.',
            'message.required' => 'Please enter your message.',
            'message.min'      => 'Message must be at least 10 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get client info
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Create contact message
        ContactMessage::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'status'     => 'unread',
        ]);

        // Redirect with success message
        return redirect()->route('contact')
            ->with('success', 'Thank you for contacting us! We have received your message and will get back to you soon.');
    }

    // ============= ADMIN METHODS =============

    /**
     * Admin: List all contact messages
     */
    public function adminIndex(Request $request)
    {
        $query = ContactMessage::latest();

        // Search functionality
        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && ! empty($request->status)) {
            $query->where('status', $request->status);
        }

        $messages = $query->paginate(20)->withQueryString();

        // Statistics
        $stats = [
            'total'   => ContactMessage::count(),
            'unread'  => ContactMessage::where('status', 'unread')->count(),
            'read'    => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
            'spam'    => ContactMessage::where('status', 'spam')->count(),
            'today'   => ContactMessage::whereDate('created_at', today())->count(),
        ];

        return view('admin.contact.index', compact('messages', 'stats'));
    }


    /**
     * Admin: Update message status and notes
     */
    public function adminUpdate(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);

        $request->validate([
            'status'      => 'required|in:unread,read,replied,spam',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $message->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('contacts.index', $id)
            ->with('success', 'Message updated successfully.');
    }

    /**
     * Admin: Delete message
     */
    public function adminDestroy($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->delete();

            return redirect()->route('contacts.index')
                ->with('success', 'Message deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete message. Please try again.');
        }
    }
  
    /**
     * Admin: Edit message form
     */
    public function adminEdit($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('admin.contact.edit', compact('message'));
    }
}
