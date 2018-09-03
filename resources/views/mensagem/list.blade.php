<h1>Lista de Mensagem</h1>
<hr>

  <!-- EXIBE MENSAGENS DE SUCESSO -->
  @if(\Session::has('success'))
	<div class="container">
  		<div class="alert alert-success">
    		{{\Session::get('success')}}
  		</div>
  	</div>
  @endif

@foreach($mensagens as $mensagem)
	<h3>Título: <b><a href="/mensagens/{{$mensagem->id}}">{{$mensagem->titulo}}</a></b></h3>
  <p>Texto: <b>{{$mensagem->texto}}</b></p>
	<p>Autor: <b>{{$mensagem->autor}}</b></p>
  <p>Ações: 
    <a href="/mensagens/{{$mensagem->id}}">Ver Mais</a>
    <a href="/mensagens/{{$mensagem->id}}/edit">Editar</a> 
    <a href="/mensagens/{{$mensagem->id}}/delete">Deletar</a>
  </p>
	<br>
@endforeach

<br>
<p><a href="/mensagens/create">Criar novo registro</a></p>