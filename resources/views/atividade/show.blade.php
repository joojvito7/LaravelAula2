<h1>Atividades {{$atividade->id}}</h1>
<hr>
<h3><b>ID:</b> {{$atividade->id}}</h3>
<h3><b>Título:</b> {{$atividade->title}}</h3>
<h3><b>Agendado para:</b> {{\Carbon\Carbon::parse($atividade->scheduledto)->format('d/m/Y h:m')}}</h3>
<h3><b>Descrição:</b> {{$atividade->description}}</h3>
<h3><b>Criada em:</b> {{\Carbon\Carbon::parse($atividade->created_at)->format('d/m/Y h:m')}}</h3>
<h3><b>Atualizada em:</b> {{\Carbon\Carbon::parse($atividade->updated_at)->format('d/m/Y h:m')}}</h3>


<br>
<br>

<h1>Mensagens Relacionadas:</h1>
<table id="tabela" name="tabela"  class="table table-striped ">
    <thead>
       <tr>
            <td>Data</td>
            <td>Título</td>
            <td>Texto</td>
        </tr>
    </thead>
    <tbody>
        @foreach($atividade->mensagens as $msg)
	        <tr>
	            <td>{{$msg->created_at}}</td>
	            <td><a href="/mensagens/{{$msg->id}}">{{$msg->titulo}}</a></td>
	            <td>{{$msg->texto}}</td>
	        </tr>
        @endforeach
    </tbody>
</table>




<!-- \Carbon\Carbon::parse($atividade->scheduledto)->format('d/m/Y h:m')  -->