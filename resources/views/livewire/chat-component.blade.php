<div>
    <section class="message-area p-0 m-0 border-top border-end border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 m-0 p-0">
                    <div class="chat-area">
                        <!-- chatbox -->
                        <div class="chatbox">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="msg-head">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="d-flex align-items-center">
                                                    <span class="chat-icon"><img class="img-fluid" src="{{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->avatar : 'https://mehedihtml.com/chatbox/assets/img/user.png' }}" alt="image title"></span>
                                                    <div class="flex-shrink-0">
                                                        <img class="rounded-circle" width="50" height="50" src="{{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->avatar : 'https://mehedihtml.com/chatbox/assets/img/user.png' }}" alt="user img">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3>{{ $job->title }}</h3>
                                                        <p>{{ $job->postedBy->name }} ,  {{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->company_name : 'NA' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <ul class="moreoption">
                                                    <li class="navbar nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Attach File</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body" id="chat-body-scroll">
                                        <div class="msg-body">
                                            <ul class="px-3">
                                                @foreach($messages as $message)
                                                    @if($message['sender_id'] != auth()->user()->id)
                                                        <li class="sender">
                                                            <p><span class="fw-semibold">{{ $message['sender'] }} :</span> {{ $message['message'] }} </p>
                                                            <span class="time">{{ $message['created_at']->format('d M Y, H:i a') }}</span>
                                                        </li>
                                                    @else
                                                         <li class="repaly">
                                                            <p>{{ $message['message'] }} : <span class="fw-semibold">You</span></p>
                                                            <span class="time">{{ $message['created_at']->format('d M Y, H:i a') }}</span>
                                                         </li>
                                                    @endif
                                                @endforeach
{{--                                                <li>--}}
{{--                                                    <div class="divider">--}}
{{--                                                        <h6>Today</h6>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}

                                            </ul>
                                        </div>
                                    </div>


                                    <div class="send-box">
                                        <form wire:submit="sendMessage()">
                                            <input type="text" wire:model="message" class="form-control" aria-label="message…" placeholder="Write message…">
                                            <button type="submit" id="sendMessage"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                                        </form>

                                        <div class="send-btns">
                                            <div class="attach">
                                                <div class="button-wrapper">
                                                    <span class="label">
                                                        <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/upload.svg" alt="image title"> attached file
                                                    </span><input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chatbox -->
                </div>
            </div>
        </div>
    </section>
</div>

@push('js')
    <script type="module">
        $(function () {
            // Scroll the content div to the bottom after the page loads
            var contentDiv = document.getElementById('chat-body-scroll');
            contentDiv.scrollTop = contentDiv.scrollHeight;

            // Function to handle all window events
            function handleEvent(event) {
                console.log(`Event '${event.type}' occurred on window`);
                contentDiv.scrollTop = contentDiv.scrollHeight;
            }

            // Attach an event listener to the window
            const sendButton = document.getElementById('sendMessage');
            sendButton.addEventListener('click', function(event) {
                // Use setTimeout to delay the call to handleEvent
                setTimeout(() => handleEvent(event), 1000); // Delay of 2 seconds (2000 ms)
            });

        });
    </script>
@endpush
