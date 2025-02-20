<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="option-1" data-bs-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">
            <b>Grupos de conexión</b>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="option-2" data-bs-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">
            <b>Asistencias</b>
        </a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="option-1">
        {{ view("people.history.tabs.tab-connection-groups", compact("people")) }}
    </div>
    <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="option-2">
        {{ view("people.history.tabs.tab-assistances-event", compact("people")) }}
    </div>
</div>