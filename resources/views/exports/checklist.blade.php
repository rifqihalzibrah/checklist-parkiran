<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Time</th>
            <th>Brand</th>
            <th>Plate</th>
            <th>Status</th>
            <th>Chief Approved</th>
            <th>Supervisor Approved</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($checklists as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ \Carbon\Carbon::parse($item->time)->format('Y-m-d H:i') }}</td>
                <td>{{ $item->brand }}</td>
                <td>{{ $item->plate }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->chief_approved ? 'Yes' : 'No' }}</td>
                <td>{{ $item->supervisor_approved ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
