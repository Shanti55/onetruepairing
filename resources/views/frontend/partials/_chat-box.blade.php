<!-- char-area -->
@livewire('chat-component',['job'=>$job,'user_id'=>auth()->user()->id == $job->postedBy->id ? $job->assignedTo->id : $job->postedBy->id])
<!-- char-area -->
