<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailFileRequest;
use App\Http\Services\File\FileService;
use App\Models\Notify\Email;
use App\Models\Notify\EmailFile;
use Illuminate\Http\Request;


class EmailFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Email $email)
    {
        return view('admin.notify.email-file.index', compact('email'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Email $email)
    {
        return view('admin.notify.email-file.create', compact('email'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailFileRequest $request, Email $email, FileService $fileService)
    {
        $inputs = $request->all();

        if($request->hasFile('file')){
            $fileService->setExclusiveDirectory('files'.DIRECTORY_SEPARATOR.'email-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            if ($request->storage == 1) {
                 // فایلهای ایمیلها معمولا مهم نیستند و در پابلیک ذخیره میکنیم
                 $result = $fileService->moveToStorage($request->file('file'));
            }else{
                // اگر حس میکنیم فایلمان مهم است در استورج ذخیره میکنیم
                $result = $fileService->moveToPublic($request->file('file'));
            }
           
            $fileFormat = $fileService->getFileFormat();
        }

        if ($result === false) {
            return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-error', 'آپلود فایل با خطا مواجه شد');
        }

        $inputs['public_mail_id'] = $email->id;
        $inputs['file_path'] = $result;
        $inputs['file_size'] = $fileSize;
        $inputs['file_type'] = $fileFormat;

        $file = EmailFile::create($inputs);
        return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-success', 'فایل جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailFile $file)
    {
        return view('admin.notify.email-file.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmailFileRequest $request, EmailFile $file, FileService $fileService)
    {
        $inputs = $request->all();

        if ($request->hasFile('file')) {
// درصورتیکه رکورد موردنظر در دیتابیس، فایلی داشت، فایل قبلی را پاک کن
            if (!empty($file->file_path)) {

                if (file_exists(storage_path($file->file_path))) {

                    $fileService->deleteFile($file->file_path, true);

                }else{

                    $fileService->deleteFile($file->file_path);
                }
            }
            
            // حالا باید فایل جدید را ثبت کند
            $fileService->setExclusiveDirectory('files'.DIRECTORY_SEPARATOR.'email-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            if ($request->storage == 1) {
                 // فایلهای ایمیلها معمولا مهم نیستند و در پابلیک ذخیره میکنیم
                 $result = $fileService->moveToStorage($request->file('file'));
            }else{
                // اگر حس میکنیم فایلمان مهم است در استورج ذخیره میکنیم
                $result = $fileService->moveToPublic($request->file('file'));
            }
           
            $fileFormat = $fileService->getFileFormat();

            if ($result === false) {
                return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-error', 'آپلود فایل با خطا مواجه شد');
            }
    
        //    فیلد زیر جون تغییر نمیکند، آن را نمینویسیم
            // $inputs['public_mail_id'] = $file->email->id;
            $inputs['file_path'] = $result;
            $inputs['file_size'] = $fileSize;
            $inputs['file_type'] = $fileFormat;
        }


        $file->update($inputs);
        return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-success', 'فایل شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailFile $file)
    {
        // فقط رکورد را در جدول پاک میکنیم و خود فایل را از استورج یا پابلیک پاک نمیکنیم، چون بخاطر سافت دیلیت ممکن است 
        // بخواهیم فایل را دوباره برگردانیم.
        $file->delete();
        return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-success', 'فایل شما با موفقیت حذف شد');
    }

    public function status(EmailFile $file)
    {
        $file->status = $file->status == 1 ? 0 : 1;
        $result = $file->save();

        if ($result) {
            if ($file->status) {
                return response()->json(['status' => true, 'checked' => true]);
            }else{
                return response()->json(['status' => true, 'checked' => false]);
            }
        }else{
            return response()->json(['status' => false]);
        }
    }
}
