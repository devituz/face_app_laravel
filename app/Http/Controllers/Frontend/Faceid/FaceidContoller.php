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


        // Adminlar sonini hisoblash
        $adminCount = $admins->count();


        // Blade faylga yuborish
        return view('pages.face-id-admins.face-id-admin.index', compact('admins', 'adminCount'));
    }






    public function create()
    {
        // Yangi adminni yaratish uchun bo'sh modelni yuborish
        return view('pages.face-id-admins.face-id-admin.create');
    }


    public function store(Request $request)
    {
        try {
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

        } catch (\Exception $e) {
            // Errorni logga yozish

            // Foydalanuvchiga xabar qaytarish
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ])->withInput(); // Foydalanuvchi kiritgan ma'lumotlarni saqlash
        }
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
        try {
            // Validatsiya qilish
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15|unique:api_admins,phone,' . $id,
                'email' => 'required|email|unique:api_admins,email,' . $id,
                'password' => 'nullable|string|min:5|confirmed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Adminni topish
            $admin = ApiAdmins::findOrFail($id);

            // Adminni yangilash
            $admin->name = $request->name;
            $admin->phone = $request->phone;
            $admin->email = $request->email;

            // Agar parol kiritilgan bo'lsa, yangilash
            if ($request->filled('password')) {
                $admin->password = $request->password;
            }

            // Rasmni yangilash
            if ($request->hasFile('image')) {
                if ($admin->image) {
                    // Eski rasmni o'chirish
                    Storage::disk('public')->delete($admin->image);
                }

                // Yangi rasmni saqlash
                $imagePath = $request->file('image')->store('faceid', 'public');
                $admin->image = $imagePath;
            }

            // Adminni saqlash
            $admin->save();

            // Muvaffaqiyatli yangilandi degan xabar bilan qaytish
            return redirect()->route('face-id-admin.index')->with('success', 'Admin successfully updated');
        } catch (\Exception $e) {
            // Xatolik yuz bersa, xatolik xabarini ko'rsatish
            return redirect()->back()
                ->with('error', $e->getMessage()) // Xatolikni aniq ko'rsatish
                ->withInput();
        }
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

    // Controllerda
    public function back(Request $request)
    {
        // Malumotlarni saqlash yoki boshqa amallarni bajarishdan so'ng
        return redirect()->back()->withInput();
    }


}
