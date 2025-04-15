<?php

namespace App\Http\Controllers\Frontend\Faceid;

use App\Http\Controllers\Controller;
use App\Models\ApiAdmins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

class FaceidContoller extends Controller
{
    public function index(Request $request)
    {
        // Qidiruv so'zini olish
        $query = trim($request->query('query', ''));

        // Adminlarni olish (query bo'lsa, name bo'yicha filterlash)
        $adminsQuery = ApiAdmins::query();

        if ($query) {
            $adminsQuery->where('name', 'like', '%' . $query . '%');
        }

        // Sahifalash (5 tadan)
        $admins = $adminsQuery->paginate(5)->appends(['query' => $query]);

        // Adminlar soni (filterlangan)
        $adminCount = $admins->total();

        // Sahifa navigatsiyasi
        $prevPage = $admins->currentPage() > 1 ? $admins->currentPage() - 1 : null;
        $nextPage = $admins->currentPage() < $admins->lastPage() ? $admins->currentPage() + 1 : null;

        // Viewga yuborish
        return view('pages.face-id-admins.face-id-admin.index', [
            'admins' => $admins,
            'adminCount' => $adminCount,
            'query' => $query,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage,
            'currentPage' => $admins->currentPage(),
            'lastPage' => $admins->lastPage(),
        ]);
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
            $admin->password = Hash::make($request->password); // ✅ Parolni hash qilish

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
        // Validatsiya: ids massiv bo'lishi va har bir id mavjud bo'lishi kerak
        $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => 'required|exists:api_admins,id',
        ]);

        try {
            $ids = $request->ids;

            // O'chirish
            $deletedCount = ApiAdmins::whereIn('id', $ids)->delete();

            // Javob
            if ($deletedCount === count($ids)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barcha adminlar muvaffaqiyatli o\'chirildi.'
                ]);
            } elseif ($deletedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ba\'zi adminlar o\'chirildi, ammo hammasi emas.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Hech qanday admin topilmadi yoki o\'chirilmadi.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }


    // Controllerda
    public function back(Request $request)
    {
        // Malumotlarni saqlash yoki boshqa amallarni bajarishdan so'ng
        return redirect()->back()->withInput();
    }


}
