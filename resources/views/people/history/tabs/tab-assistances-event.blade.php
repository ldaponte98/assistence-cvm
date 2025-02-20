<div class="table-responsive">
    <table class="table text-nowrap mb-0 data-table" id="tab-1">
        <thead class="table-light">
            <tr>
                <th class="center"><b>Evento</b></th>
                <th class="center"><b>¿Asistio?</b></th>
                <th class="center"><b>¿Fue nuevo asistente?</b></th>
                <th class="center"><b>Fecha asistencia</b></th>
                <th class="center"><b>Tipo evento</b></th>
                <th class="center"><b>Red</b></th>
                <th class="center"><b>Grupo de conexión</b></th>
                <th class="center"><b>Fechas del evento</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($people->getAssistances() as $item)
            <tr>
                <td>{{ $item->event->title }}</td>
                <td class="center">
                    <span class="badge bg-{{$item->assistance->attended == 1 ? 'success' : 'danger'}}">
                        {{ $item->assistance->attended == 1 ? 'Sí' : 'No'}}
                    </span>
                </td>
                <td class="center">
                    <span class="badge bg-{{$item->assistance->isNew == 1 ? 'success' : 'info'}}">
                        {{ $item->assistance->isNew == 1 ? 'Sí' : 'No'}}
                    </span>
                </td>
                <td>{{ date('Y-m-d H:i:s', strtotime($item->assistance->created_at)) }}</td>
                <td>{{ $item->event->getTextType()}}</td>
                <td>{{ $item->event->getTextRed()}}</td>
                <td>{{ $item->event->getInfoType()}}</td>
                <td>{{ $item->event->getDateInfo()}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>