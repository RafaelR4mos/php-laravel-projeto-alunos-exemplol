<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Aluno;

class AlunosController extends Controller
{
    public function index()
    {
        //Com limite de busca
        $alunos = Aluno::orderBy('created_at', 'desc')->take(15)->get();

        //Com Where
        //$alunos = Aluno::where('nm_aluno', 'Aron Renner')->get();

        return view('alunos.index', [
            'alunos' => $alunos
        ]);
    }

    public function create()
    {
        return view('alunos.create');
    }

    public function insert(Request $request)
    {
        $aluno = new Aluno();

        $aluno->nm_aluno = $request->input('nm_aluno');
        $aluno->nm_curso = $request->input('nm_curso');
        $aluno->nu_ano = $request->input('nu_ano');
        $aluno->nu_semestre = $request->input('nu_semestre');

        $aluno->save();

        return redirect('alunos');
    }

    public function destroy(int $id_aluno)
    {
        $aluno_to_delete = Aluno::find($id_aluno);
        if($aluno_to_delete->delete()) {
            return redirect('alunos');
        } else {
            return response()->json([
                'error' => 'Não foi possível excluir o recurso. Verifique os dados e tente novamente.'
            ], 422);
        }
    }

    public function edit(int $id_aluno)
    {
        $aluno_data = Aluno::find($id_aluno);

        return view('alunos.edit', [
            'aluno' => $aluno_data
        ]);
    }

    public function update(Request $request, int $id_aluno)
    {
        $aluno = Aluno::find($id_aluno);

        $aluno_editado = [
            'nm_aluno' => $request->input('nm_aluno'),
            'nm_curso' => $request->input('nm_curso'),
            'nu_ano' => $request->input('nu_ano'),
            'nu_semestre' => $request->input('nu_semestre')
        ];

        if($aluno->update($aluno_editado)) {
            return redirect('alunos');
        } else {
            return response()->json([
                'error' => 'Ocorreu um erro ao tentar editar o aluno'
            ], 400);
        }
    }
}
