<x-modal-confirm
    livewire-event-to-open-modal="markAsNotSpamCommentWasSet"
    event-to-close-modal="commentWasMarkedAsNotSpam"
    modal-title="Reset Comment Spam Counter"
    modal-description="Are you sure you want to mark this comment as NOT spam? This will reset the spam counter to 0."
    modal-confirm-button-text="Reset Spam Counter"
    wire-click="markAsNotSpam"
/>
