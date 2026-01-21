<div x-data="unreadCount{{ $id }}">
    <template x-if="count > 0">
        <span class="badge rounded-pill bg-danger">
            <span x-text="count"></span>
        </span>
    </template>
</div>

<div x-data="unreadCount{{ $id }}">
    <template x-if="count > 0">
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <span x-text="count"></span>
        </span>
    </template>
</div>

{{-- Script ko sirf EK baar push karein --}}
@push('js')
@once
    <script>
        var unreadCount{{ $id }} = () => {
            return {
                count: 0,
                async init(){
                    await this.fetchCount();
                },
                async fetchCount(){
                    try {
                        let response = await axios.get(route('inbox.get-unread-count'));
                        this.count = response.data.count;
                    } catch (e) {
                        console.log("Error fetching count");
                    }
                }
            }
        }
    </script>
@endonce
@endpush