<div x-data="inbox">
    <template x-for="(notification, index) in notifications">
        <div class="border-bottom notification-item cursor-pointer px-4 py-3 "
             :class="!notification.read_at ? 'bg-light' : ''"
             x-intersect="markAsRead(notification.read_at, notification.id);if(index+1 == notifications.length) fetchMore();"
             :key="notification.id">
            <template
                x-if="notification.data.type == 'job_status'">
                @include('frontend.partials.inbox._notifications.job_status')
            </template>
            <template
                x-if="notification.data.type == 'offline_verification_status'">
                @include('frontend.partials.inbox._notifications.offline_verification_status')
            </template>
            <template
                x-if="notification.data.type == 'client_job_created'">
                @include('frontend.partials.inbox._notifications.job_status')
            </template>
        </div>
    </template>
    <template x-if="loading">
        <div>
            <div>
                <div>
                    <div class="p-3 pb-3 mb-3">
                        <div class="line-loader"></div>
                        <div class="line-loader w-50 mt-2"></div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="p-3 pb-3 mb-3 ">
                        <div class="line-loader"></div>
                        <div class="line-loader w-50 mt-2"></div>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <div class="p-3 pb-3 mb-3">
                        <div class="line-loader"></div>
                        <div class="line-loader w-50 mt-2"></div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="p-3 pb-3 mb-3 ">
                        <div class="line-loader"></div>
                        <div class="line-loader w-50 mt-2"></div>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <div class="p-3 pb-3 mb-3">
                        <div class="line-loader"></div>
                        <div class="line-loader w-50 mt-2"></div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="p-3 pb-3 mb-3 ">
                        <div class="line-loader"></div>
                        <div class="line-loader w-50 mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

    </template>
    <template x-if="notifications.length <= 0 && !loading">
        <div class="card-body text-center">
            <i class="bi bi-inbox" style="font-size: 9rem; color: gray;"></i>
            <h3 style="color: gray;">Inbox is empty!</h3>
        </div>
    </template>
</div>


@push('js')
    <script>
        inbox = () => {
            return {
                notifications: [],
                loading: true,
                skip: 5,
                init() {
                    this.fetchData();
                },
                async fetchData() {
                    let response = await axios.get(route('inbox.get-notifications', {
                        skip: 0,
                    }));
                    this.notifications = response.data.notifications;
                    this.loading = false;
                },
                async fetchMore() {
                    let response = await axios.get(route('inbox.get-notifications', {
                        skip: this.skip,
                    }));
                    this.notifications.push(...response.data.notifications);
                    this.skip += 5;
                },
                async markAsRead(isRead, id) {
                    if (!isRead)
                        await axios.get(route('inbox.read-notification', {id: id}));
                }

            }
        }
    </script>
@endpush
