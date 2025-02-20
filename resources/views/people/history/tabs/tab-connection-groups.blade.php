<div class="table-responsive">
    <table class="table text-nowrap mb-0 data-table" id="tab-1">
        <thead class="table-light">
            <tr>
                <th class="center"><b>Grupo</b></th>
                <th class="center"><b>Estado</b></th>
                <th class="center"><b>Red</b></th>
                <th class="center"><b>Lideres</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($people->getConnectionGroups() as $item)
            <tr>
                <td>{{ $item->group->name }}</td>
                <td class="center">
                    @if ($item->assist == 1)
                        <span class="badge bg-success">Asitiendo actualmente</span>
                    @else
                        <span class="badge bg-danger">Ya no asiste</span>
                    @endif
                </td>
                <td>{{ \App\Shared\RedType::get($item->group->red) }}</td>
                <td>{{ $item->group->getTextLeaders() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>