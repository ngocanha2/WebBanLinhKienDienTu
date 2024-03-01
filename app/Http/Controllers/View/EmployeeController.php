<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\nhanvien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function getList(Request $request)//truyền id đăng nhập
    {
        $user = Auth::guard("admin-api")->user();
        $data = DB::select("select * from nhanvien");
        //lấy chức vụ kiểm tra (cho sửa nhân viên bên admin)=>  để lấy chức vụ
        $chucVu = DB::table("nhanvien")->where('MaNV',$user->MaNV)->value("ChucVu");

        return view("employees.employee",["nhanviens"=>$data, "chucvu"=>$chucVu]);
    }
    public function viewInsert()
    {
        return view("employees.insert-employee");
    }
    public function insertEmployee(Request $request)
    {
      $tenNV = $request->input("txt_TenNV");
      $tenDN = $request->input("txt_TenDangNhap");
      $matKhau = $request->input("txt_MatKhau");
      $diaChi = $request->input("txt_DiaChi");
      $ngaySinh = $request->input("txt_NgaySinh");
      $gioiTinh = $request->input("cbo_GioiTinh");
      $sdt = $request->input("txt_SDT");
      $chucVu = $request->input("cbo_ChucVu");
      //$hinhAnh = $request->input("hinh_anh");
      $insertNhanVien = DB::table("nhanvien")->insert([
        "TenNV"=> "$tenNV",
        "TenDangNhap"=> "$tenDN",
        "MatKhau"=> "$matKhau",
        "NgaySinh"=> "$ngaySinh",
        "GioiTinh"=> "$gioiTinh",
        "SDTNV"=> "$sdt",
        "DiaChi"=> "$diaChi",
        "ChucVu"=> "$chucVu",
      ]); 
    return redirect("employee");
    }
    public function getDetail(Request $request, $id)
    {
        $data = DB::select("select * from nhanvien WHERE MaNV = '$id'");

        return view("employees.detail-employee",["nhanvien"=>$data]);
    }
    public function updateEmployee(Request $request, $id)
    {
      $tenNV = $request->input("txt_TenNV");
      $tenDN = $request->input("txt_TenDangNhap");
      $matKhau = $request->input("txt_MatKhau");
      $diaChi = $request->input("txt_DiaChi");
      $ngaySinh = $request->input("txt_NgaySinh");
      $gioiTinh = $request->input("cbo_GioiTinh");
      $sdt = $request->input("txt_SDT");
      $chucVu = $request->input("cbo_ChucVu");

      $data = DB::select("update nhanvien set TenNV = '$tenNV', TenDangNhap = '$tenDN', 
      MatKhau = '$matKhau', DiaChi = '$diaChi', NgaySinh = '$ngaySinh', GioiTinh = '$gioiTinh',
       SDTNV = '$sdt', ChucVu = '$chucVu'
        where MaNV = $id");

        return redirect("employee");
    }
    public function viewInformation()
    {

        
        return view("employees.information-employee");
    }
    public function getInformation() //truyền id từ đăng nhập
    {
        $user = Auth::guard("admin-api")->user();
        $data = DB::select("select * from nhanvien WHERE MaNV = $user->MaNV");

        return view("employees.information-employee",["nhanvieninfo"=>$data]);
    }
    public function updateEmployeeInfo(Request $request)//truyền id từ đăng nhập
    {
        $user = Auth::guard("admin-api")->user();
      $tenNV = $request->input("txt_TenNV");
      $tenDN = $request->input("txt_TenDangNhap");
      $matKhau = $request->input("txt_MatKhau");
      $diaChi = $request->input("txt_DiaChi");
      $ngaySinh = $request->input("txt_NgaySinh");
      $gioiTinh = $request->input("txt_GioiTinh");
      $sdt = $request->input("txt_SDT");

      $data = DB::select("update nhanvien set TenNV = '$tenNV', TenDangNhap = '$tenDN', 
      MatKhau = '$matKhau', DiaChi = '$diaChi', NgaySinh = '$ngaySinh', GioiTinh = '$gioiTinh',
       SDTNV = '$sdt'
        where MaNV = $user->MaNV");

        return redirect()->back();
    }   

    public function getViewPass(Request $request)
    {
        return view("employees.change-password");
    }
    public function updatePass(Request $request)//truyền id từ đăng nhập
    {
        $mkHienTai = $request->input("txt_MatKhauHienTai");
        $mkMoi = $request->input("txt_MatKhauMoi");
        $mkMoi1 = $request->input("txt_MatKhauMoi1");
        $user = Auth::guard("admin-api")->user();         
        if(!Hash::check($mkHienTai, $user->password))
            return redirect()->back()->with('error', 'Mật khẩu hiện tại chưa đúng');;
        if($mkMoi==$mkMoi1)
        {
            $user->password = $mkMoi;
            $user->save();
            return redirect("information-employee");
        }
        return redirect()->back()->with('error', 'Mật khẩu nhập lại không chính xác');;        
    }
    public function resetPassword($id)
    {
        $nhanVien = nhanvien::find($id);
        $nhanVien->password = "123";
        $nhanVien->save();
               
        return redirect("/employee");
    }
}
