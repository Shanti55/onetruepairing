<table>
    <thead>
    <tr>
        <th style="text-align: center;" colspan="{{ 9 }}">Job Accepted/Declined Report</th>
    </tr>
    <tr>
        <th style="background: #cccccc">Sr. No.</th>
        <th style="background: #cccccc">Company Name</th>
        <th style="background: #cccccc">Name</th>
        <th style="background: #cccccc">Email</th>
        <th style="background: #cccccc">Phone</th>
        <th style="background: #cccccc">Job Accepted</th>
        <th style="background: #cccccc">In Progress</th>
        <th style="background: #cccccc">Completed</th>
        <th style="background: #cccccc">Declined</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $index=>$user)
        @php
            $profile = $user->serviceproviderprofile ?? null;
        @endphp
    <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $profile->company_name ?? 'NA' }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $profile->contact_number }}</td>
        <td>{{ getJobAcceptedCount($user) }}</td>
        <td>{{ getJobInProgressCount($user) }}</td>
        <td>{{ getJobCompletedCount($user) }}</td>
        <td>{{ getJobDeclinedCount($user) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
