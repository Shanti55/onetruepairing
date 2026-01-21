<div  x-data="inboxOfflineVerificationStatus(notification.data,notification.notifiable_id)">
    <a :href="notification.data.link" class="text-dark">
        <div class="d-flex align-items-start w-100 d-inline-flex gap-3">
            <div class="avatar avatar-md  border rounded mt-1 mr-3 d-flex align-items-center justify-content-center bg-warning text-white">
                <span x-text="serviceProvider.userName.charAt(0)"></span>
            </div>
            <div class="d-flex flex-column">
                <span x-html="notification.data.message"></span>
                <small class="text-secondary" x-text="moment(notification.created_at).fromNow()"></small>
                <div class="mt-2 d-flex align-items-center">
                    <div x-show="loading" class="line-loader w-25"></div>
                    <div x-show="!loading">
                        <span class="badge" :class="notification.data.data.current_status_color"><span x-text="notification.data.data.current_status"></span></span>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@push('js')
    <script>
        let inboxOfflineVerificationStatus = (data,notifiableId) => {
            return {
                notifiableId: notifiableId,
                loading: true,
                data: data,
                serviceProvider: {},
                init() {
                    this.fetchData();
                },
                async fetchData() {
                    try {
                        let response = await axios.get(route('notification.get-offline-verification-status', {
                            service_provider_id: data.data.service_provider_id,
                        }));
                        this.serviceProvider = response.data.serviceProvider;
                        this.loading = false;
                    } catch (e) {
                        this.loading = false;
                    }
                },
            }
        }
    </script>

@endpush

