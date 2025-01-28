<?php

namespace App\Http\Controllers\Frontend\Faceid;

use App\Http\Controllers\Controller;
use App\Models\ApiAdmins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaceidContoller extends Controller
{
    public function index()
    {
        // ApiAdmins modelidan barcha adminlarni olish
        $admins = ApiAdmins::all();



        // Blade faylga yuborish
        return view('pages.face-id-admins.face-id-admin.face-id-admin', compact('admins'));
    }



    public function create()
    {
        // Yangi adminni yaratish uchun bo'sh modelni yuborish
        return view('pages.face-id-admins.face-id-admin.create');
    }


    public function store(Request $request)
    {
        // Validatsiya qilish
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:api_admins',
            'email' => 'required|email|unique:api_admins',
            'password' => 'required|string|min:5|confirmed',  // Parolni tasdiqlash
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Rasmni validatsiya qilish
        ]);

        // Adminni yaratish
        $admin = new ApiAdmins();
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->email = $request->email;
        $admin->password = $request->password;

        // Agar rasm yuklangan bo‘lsa, uni saqlash
        if ($request->hasFile('image')) {
            // Rasmni 'storage/app/public/faceid' papkasiga yuklash
            $imagePath = $request->file('image')->store('faceid', 'public');
            $admin->image = $imagePath;
        }

        // Adminni saqlash
        $admin->save();

        return redirect()->route('face-id-admin.index')->with('success', 'Admin successfully added');
    }





    public function edit($id)
    {
        // ID bo'yicha adminni olish
        $admin = ApiAdmins::findOrFail($id);

        // Blade faylga yuborish (adminni tahrirlash uchun)
        return view('pages.face-id-admins.face-id-admin.edit', compact('admin'));
    }




    public function update(Request $request, $id)
    {
        // Validatsiya qilish
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:api_admins,phone,' . $id, // Tahrirda faqat bitta telefon raqami takrorlanishi mumkin
            'email' => 'required|email|unique:api_admins,email,' . $id, // Tahrirda faqat bitta email takrorlanishi mumkin
            'password' => 'nullable|string|min:5|confirmed', // Parolni tasdiqlash, agar bo‘lsa
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Rasmni validatsiya qilish
        ]);

        // Adminni olish
        $admin = ApiAdmins::findOrFail($id);

        // Adminni yangilash
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->email = $request->email;

        // Parolni yangilash, agar yangi parol kiritilgan bo‘lsa
        if ($request->filled('password')) {
            $admin->password = $request->password;
        }

        // Agar rasm yuklangan bo‘lsa, uni saqlash
        if ($request->hasFile('image')) {
            // Eski rasmni o‘chirish (agar bo‘lsa)
            if ($admin->image) {
                Storage::disk('public')->delete($admin->image);
            }

            // Yangi rasmni yuklash
            $imagePath = $request->file('image')->store('faceid', 'public');
            $admin->image = $imagePath;
        }

        // Adminni yangilash
        $admin->save();

        // Yuborilgan xabar bilan qaytish
        return redirect()->route('face-id-admin.index')->with('success', 'Admin successfully updated');
    }


    public function destroy($id)
    {
        // ID bo'yicha adminni olish
        $admin = ApiAdmins::findOrFail($id);

        // Adminni o'chirish
        $admin->delete();

        // Yuborilgan xabar bilan qaytish
        return redirect()->route('face-id-admin.index')->with('success', 'Admin successfully deleted');
    }


    public function bulkDestroy(Request $request)
    {
        // Yuborilgan IDlar
        $ids = $request->ids;

        // IDlar bo'yicha adminlarni o'chirish
        ApiAdmins::whereIn('id', $ids)->delete();

        // Yuborilgan xabar bilan qaytish
        return response()->json(['success' => 'Admins successfully deleted']);
    }

}
