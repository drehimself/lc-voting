<x-modal-confirm
    event-to-open-modal="custom-show-mark-idea-as-spam-modal"
    event-to-close-modal="ideaWasMarkedAsSpam"
    modal-title="Mark Idea as Spam"
    modal-description="Are you sure you want to mark this idea as spam?"
    modal-confirm-button-text="Mark as Spam"
    wire-click="markAsSpam"
/>
