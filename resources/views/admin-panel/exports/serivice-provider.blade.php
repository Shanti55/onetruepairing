<table>
    <thead>
    <tr>
        <th style="text-align: center;" colspan="{{ 13 }}">Service Providers List</th>
    </tr>
    <tr>
        <th style="background: #cccccc">Sr. No.</th>
        <th style="background: #cccccc">Company Name</th>
        <th style="background: #cccccc">Name</th>
        <th style="background: #cccccc">Email</th>
        <th style="background: #cccccc">Phone</th>
        <th style="background: #cccccc">Address</th>
        <th style="background: #cccccc">Pin Code</th>
        <th style="background: #cccccc">City</th>
        <th style="background: #cccccc">Region</th>
        <th style="background: #cccccc">State</th>
        <th style="background: #cccccc">Created At</th>
        <th style="background: #cccccc">Offline Verification</th>
        <th style="background: #cccccc">Status</th>
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
        <td>{{ $profile->address ?? 'NA' }}</td>
        <td>{{ $profile->pin_code ?? 'NA' }}</td>
        <td>{{ $profile->city ?? 'NA' }}</td>
        <td>{{ $profile->region ?? 'NA' }}</td>
        <td>{{ $profile->state ?? 'NA' }}</td>
        <td>{{ $user->created_at ?? 'NA' }}</td>
        <td>{{ $user->offline_verification->value }}</td>
        <td>{{ $user->status->value }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
