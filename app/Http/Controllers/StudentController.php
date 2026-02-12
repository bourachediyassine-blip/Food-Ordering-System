<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

class StudentController extends Controller
{
    public function index()
    {
        // تم تغيير الفرز ليناسب المسمى الجديد employeur
        $students = Student::where('type', 'student')->orderBy('created_at', 'desc')->get();
        $staff = Student::where('type', 'employeur')->orderBy('created_at', 'desc')->get();
        
        return view('index', compact('students', 'staff'));
    }

    public function showScanPage()
    {
        return view('scan');
    }

    public function processScan(Request $request)
    {
        $member = Student::where('student_id', $request->student_id)->first();

        if (!$member) {
            return back()->with('error', 'Membre non trouvé !');
        }

        // --- منطق الخصم للعمال (Employeur) ---
        if ($member->type == 'employeur') {
            if ($member->balance < 20) {
                return back()->with('error', 'Solde insuffisant pour ' . $member->name . ' (Moins de 20 DA)');
            }

            // خصم 20 دج وتحديث الرصيد
            $member->decrement('balance', 20);
            return back()->with('success', 'Bon appétit ' . $member->name . ' | -20 DA (Reste: ' . $member->balance . ' DA)');
        }

        // --- منطق الوجبة الواحدة يومياً للطلاب ---
        $today = Carbon::today();
        if ($member->last_meal_at && Carbon::parse($member->last_meal_at)->isToday()) {
            return back()->with('error', 'Désolé, ' . $member->name . ' a déjà pris son repas !');
        }

        $member->update(['last_meal_at' => Carbon::now()]);
        return back()->with('success', 'Bon appétit : ' . $member->name);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:students,student_id',
            'type' => 'required|in:student,employeur', // تم تغيير staff إلى employeur
            'class_name' => 'nullable|string',
            'balance' => 'nullable|numeric',
        ]);

        Student::create($data);
        return back()->with('success', 'Ajouté avec succès !');
    }

    public function update(Request $request, $id)
    {
        $member = Student::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:students,student_id,' . $id,
            'type' => 'required|in:student,employeur', // تم تغيير staff إلى employeur
            'class_name' => 'nullable|string',
            'balance' => 'nullable|numeric',
        ]);

        $member->update($data);
        return back()->with('success', 'Mis à jour !');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return back()->with('success', 'Supprimé !');
    }
}