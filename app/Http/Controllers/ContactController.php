<?php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Show contact form
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required'    => 'Please enter your name.',
            'name.string'      => 'Name must be a valid text.',
            'name.max'         => 'Name should not exceed 255 characters.',
            'email.required'   => 'Please enter your email address.',
            'email.email'      => 'Please enter a valid email address.',
            'email.max'        => 'Email should not exceed 255 characters.',
            'phone.string'     => 'Phone number must be valid.',
            'phone.max'        => 'Phone number should not exceed 20 characters.',
            'subject.string'   => 'Subject must be a valid text.',
            'subject.max'      => 'Subject should not exceed 255 characters.',
            'message.required' => 'Please enter your message.',
            'message.string'   => 'Message must be a valid text.',
            'message.min'      => 'Message must be at least 10 characters.',
            'message.max'      => 'Message should not exceed 2000 characters.',
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
        $contactMessage = ContactMessage::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'status'     => 'unread',
        ]);

        // Send email notification to admin (optional)
        // Uncomment if you want to send email
        /*
        try {
            $adminEmail = config('mail.from.address', 'admin@example.com');
            Mail::to($adminEmail)->send(new ContactFormSubmitted($contactMessage));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact email: ' . $e->getMessage());
        }
        */

        // Send confirmation email to user (optional)
        /*
        try {
            Mail::to($request->email)->send(new ContactConfirmation($contactMessage));
        } catch (\Exception $e) {
            \Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }
        */

        // Redirect with success message
        return redirect()->route('contact')
            ->with('success', 'Thank you for contacting us! We have received your message and will get back to you soon.');
    }

    /**
     * Admin: List all contact messages
     */
    public function adminIndex(Request $request)
    {

        $query = ContactMessage::latest();

        // Search functionality
        if ($request->has('search') && $request->search) {
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
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $messages = $query->paginate(20);

        // Statistics
        $stats = [
            'total'   => ContactMessage::count(),
            'unread'  => ContactMessage::where('status', 'unread')->count(),
            'read'    => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
            'today'   => ContactMessage::whereDate('created_at', today())->count(),
        ];

        return view('admin.contacts.index', compact('messages', 'stats'));
    }

    /**
     * Admin: View single message
     */
    public function adminShow($id)
    {
        $message = ContactMessage::findOrFail($id);

        // Mark as read when viewed
        if ($message->status == 'unread') {
            $message->markAsRead();
        }

        return view('admin.contacts.show', compact('message'));
    }

    /**
     * Admin: Update message status
     */
    public function adminUpdate(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);

        $request->validate([
            'status'      => 'required|in:unread,read,replied,spam',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $message->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.contacts.show', $id)
            ->with('success', 'Message updated successfully.');
    }

    /**
     * Admin: Delete message
     */
    public function adminDestroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted successfully.');
    }

    /**
     * Admin: Mark all as read
     */
    public function adminMarkAllRead()
    {
        ContactMessage::where('status', 'unread')->update(['status' => 'read']);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'All messages marked as read.');
    }
}
