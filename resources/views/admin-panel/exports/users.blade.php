<table>
    <thead>
    <tr>
        <th style="text-align: center;" colspan="{{ 10 }}">Users List</th>
    </tr>
    <tr>
        <th style="background: #cccccc">Sr. No.</th>
        <th style="background: #cccccc">Name</th>
        <th style="background: #cccccc">Email</th>
        <th style="background: #cccccc">Phone</th>
        <th style="background: #cccccc">Address</th>
        <th style="background: #cccccc">Pin Code</th>
        <th style="background: #cccccc">City</th>
        <th style="background: #cccccc">Region</th>
        <th style="background: #cccccc">State</th>
        <th style="background: #cccccc">Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $index=>$user)
        @php
            $profile = $user->userprofile ?? null;
        @endphp
    <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $profile->contact_number ?? 'NA' }}</td>
        <td>{{ $profile->address ?? 'NA' }}</td>
        <td>{{ $profile->pin_code ?? 'NA' }}</td>
        <td>{{ $profile->city ?? 'NA' }}</td>
        <td>{{ $profile->region ?? 'NA' }}</td>
        <td>{{ $profile->state ?? 'NA' }}</td>
        <td>{{ $user->created_at ?? 'NA' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
