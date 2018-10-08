<?php
namespace App\Http\Controllers;
use App\Atividade;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class AtividadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //checa se o usuário está cadastrado
        if( Auth::check() ){   
            //retorna somente as atividades cadastradas pelo usuário cadastrado
            $listaAtividades = Atividade::where('user_id', Auth::id() )->get();     
        }else{
            //retorna todas as atividades
            $listaAtividades = Atividade::all();
        }
        
        return view('atividade.list',['atividades' => $listaAtividades]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('atividade.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //faço as validações dos campos
        //vetor com as mensagens de erro
        $messages = array(
            'title.required' => 'É obrigatório um título para a atividade',
            'description.required' => 'É obrigatória uma descrição para a atividade',
            'scheduledto.required' => 'É obrigatório o cadastro da data/hora da atividade',
        );
        //vetor com as especificações de validações
        $regras = array(
            'title' => 'required|string|max:255',
            'description' => 'required',
            'scheduledto' => 'required|string',
        );
        //cria o objeto com as regras de validação
        $validador = Validator::make($request->all(), $regras, $messages);
        //executa as validações
        if ($validador->fails()) {
            return redirect('atividades/create')
            ->withErrors($validador)
            ->withInput($request->all);
        }
        //se passou pelas validações, processa e salva no banco...
        $obj_Atividade = new Atividade();
        $obj_Atividade->title =       $request['title'];
        $obj_Atividade->description = $request['description'];
        $obj_Atividade->scheduledto = $request['scheduledto'];
        $obj_Atividade->user_id     = Auth::id();
        $obj_Atividade->save();
        return redirect('/atividades')->with('success', 'Atividade criada com sucesso!!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Atividade  $atividade
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $atividade = Atividade::find($id)->with('mensagens')->get()->first();
        return view('atividade.show',['atividade' => $atividade]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Atividade  $atividade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //busco os dados do obj Atividade que o usuário deseja editar
        $obj_Atividade = Atividade::find($id);
        
        //verifico se o usuário logado é o dono da Atividade
        if( Auth::id() == $obj_Atividade->user_id ){
            //retorno a tela para edição
            return view('atividade.edit',['atividade' => $obj_Atividade]);    
        }else{
            //retorno para a rota /atividades com o erro
            return redirect('/atividades')->withErrors("Você não tem permissão para editar este item");
        }
           
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Atividade  $atividade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //faço as validações dos campos
        //vetor com as mensagens de erro
        $messages = array(
            'title.required' => 'É obrigatório um título para a atividade',
            'description.required' => 'É obrigatória uma descrição para a atividade',
            'scheduledto.required' => 'É obrigatório o cadastro da data/hora da atividade',
        );
        //vetor com as especificações de validações
        $regras = array(
            'title' => 'required|string|max:255',
            'description' => 'required',
            'scheduledto' => 'required|string',
        );
        //cria o objeto com as regras de validação
        $validador = Validator::make($request->all(), $regras, $messages);
        //executa as validações
        if ($validador->fails()) {
            return redirect('atividades/$id/edit')
            ->withErrors($validador)
            ->withInput($request->all);
        }
        //se passou pelas validações, processa e salva no banco...
        $obj_atividade = Atividade::findOrFail($id);
        $obj_atividade->title =       $request['title'];
        $obj_atividade->description = $request['description'];
        $obj_atividade->scheduledto = $request['scheduledto'];
        $obj_atividade->user_id     = Auth::id();
        $obj_atividade->save();
        return redirect('/atividades')->with('success', 'Atividade alterada com sucesso!!');
    }
    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Atividade  $atividade
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $obj_Atividade = Atividade::find($id);
        
        //verifico se o usuário logado é o dono da Atividade
        if( Auth::id() == $obj_Atividade->user_id ){
            //retorno o formulário questionando se ele tem certeza
            return view('atividade.delete',['atividade' => $obj_Atividade]);    
        }else{
            //retorno para a rota /atividades com o erro
            return redirect('/atividades')->withErrors("Você não tem permissão para deletar este item");
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Atividade  $atividade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj_atividade = Atividade::findOrFail($id);
        $obj_atividade->delete($id);
        return redirect('/atividades')->with('sucess','Atividade excluída com Sucesso!!');
    }
}
