<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RegistrationApplication;
use App\Models\User;
use App\Models\Result;
use App\Models\Role;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    } 

    private $itemsByPage = 5;

    public function resultsForm(){
        $role_id = Role::getForStudent();
        $resultsPaginator = User::where('role_id', '=', $role_id)->with('results')->paginate($this->itemsByPage);
        // $testResults = Result::where('student_id', '=', $id)->with('tests')->paginate(5);
        // dd($resultsPaginator);
        
        $groups = Group::select('name')->get();

        return view('admin.students', compact('resultsPaginator', 'groups'));
    }

    public function filterStudents(Request $request){
        $queryParams = $request->all();

        $role_id = Role::getForStudent();
        
        if(isset($queryParams['group']) && isset($queryParams['name'])){
            $resultsPaginator = User::select('name', 'surname', 'patronymic', 'role_id', 'group', 'id')
                ->where('role_id', '=', $role_id)
                ->where('group', $queryParams['group'] ? '=' : '!=', $queryParams['group'])
                ->where(DB::raw('CONCAT(name, " ", surname, " ", patronymic)'), $queryParams['name'] ? 'LIKE' : '!=', "%" . $queryParams['name'] . "%")
                ->with('results')
                ->paginate($this->itemsByPage)->appends(request()->except('page'));
        } else if(isset($queryParams['group'])) {
            $resultsPaginator = User::select('name', 'surname', 'patronymic', 'role_id', 'group', 'id')
                ->where('role_id', '=', $role_id)
                ->where('group', $queryParams['group'] ? '=' : '!=', $queryParams['group'])
                ->with('results')
                ->paginate($this->itemsByPage)->appends(request()->except('page'));
        } else if(isset($queryParams['name'])){
            $resultsPaginator = User::select('name', 'surname', 'patronymic', 'role_id', 'group', 'id')
                ->where('role_id', '=', $role_id)
                ->where(DB::raw('CONCAT(name, " ", surname, " ", patronymic)'), $queryParams['name'] ? 'LIKE' : '!=', "%" . $queryParams['name'] . "%")
                ->with('results')
                ->paginate($this->itemsByPage)->appends(request()->except('page'));
        } else {
            $resultsPaginator = User::select('name', 'surname', 'patronymic', 'role_id', 'group', 'id')
                ->where('role_id', '=', $role_id)
                ->with('results')
                ->paginate($this->itemsByPage)->appends(request()->except('page'));

            $queryParams = [
                'name' => '',
                'group' => '',
            ];
        }
        
        // Пример SQL-запроса
        // SELECT * FROM `users` WHERE CONCAT(`name`, " ", `surname`, " ", `patronymic`) LIKE "%Максим%"
        
        $groups = Group::select("name")->get();

        return view('admin.students', compact('resultsPaginator', 'groups', 'queryParams'));
    }

    public function studentsTestsForm($id){
        $student = User::find($id);
        $testResults = Result::where('student_id', '=', $id)->with('tests')->paginate(5);

        if(!isset($student) || !isset($testResults))
            return redirect()->route('students-filter');

        return view('admin.students_test_list', compact('student', 'testResults'));
    }

    public function studentTestConfirm(Request $request){
        $result_id = $request->all()['result_id'];
        if(!isset($result_id))
            return redirect()->route('tests-list');

        $result = Result::where('id', '=', $result_id)->first();
        if(!isset($result))
            return redirect()->route('tests-list');

        $result->confirm();

        return redirect()->back();
    }

    public function confirmationRegistrationForm(){
        $students = RegistrationApplication::where('confirmed_at', '=', null)->paginate(3);

        return view('admin.confirmation_registration', compact('students'));
    }

    public function confirmationRegistration(Request $request){
        $user = RegistrationApplication::find($request->all()['user_id']);

        if ($user) $user->confirm();

        return redirect()->route('confirmation-form');
    }
}
