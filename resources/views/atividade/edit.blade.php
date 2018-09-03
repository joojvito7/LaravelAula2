
<h1>Formulário de Edição da Atividade código {{$atividade->id}}</h1>
<hr>

  <!-- EXIBE MENSAGENS DE ERROS -->
  @if ($errors->any())
	<div class="container">
	  <div class="alert alert-danger">
	    <ul>
	      @foreach ($errors->all() as $error)
	      <li>{{ $error }}</li>
	      @endforeach
	    </ul>
	  </div>
	</div>
  @endif

<form action="/atividades/{{$atividade->id}}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	Título: 		<input type="text" name="title" value="{{$atividade->title}}"> 	     <br>
	Descrição:		<input type="text" name="description" value="{{$atividade->description}}">   <br>
	Agendado para:  <input type="datetime-local" name="scheduledto" value="{{$atividade->scheduledto}}">   <br>
	<input type="submit" value="Salvar">
</form>


