<?php

namespace Modules\User\Http\Controllers\Admin;

use App\helpers\convertToEnglish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ACL\Repositories\RoleRepository;
use Modules\Media\Http\Controllers\MediaController;
use Modules\StateCityRegion\City\Repository\CityRepository;
use Modules\StateCityRegion\State\Repository\StateRepository;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Repositories\ActivityRepository;
use Modules\User\Repositories\UserRepository;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;
    private $mediaController;
    private $stateRepository;
    private $cityRepository;
    public function __construct(UserRepository $userRepository,CityRepository  $cityRepository, RoleRepository $roleRepository, MediaController $mediaController,ActivityRepository $activityRepository,StateRepository $stateRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->mediaController = $mediaController;
        $this->activityRepository = $activityRepository;
        $this->stateRepository=$stateRepository;
        $this->cityRepository=$cityRepository;

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

//        dd(is_null($request->from),isset($request->to));
        $users = $this->userRepository->all_with_paginate($request->search,$request->city,$request->activity,$request->from,$request->to,$request->per_page);
        $users->load('roles');
        $tags=$this->get_tags($request);

        $users->appends($request->except(['per_page'=>$request->per_page??20]));
        $users->appends($request->except(['per_page'=>$request->per_page??20]));
        $users->map(function ($detail, $key)  {
            $detail->setAttribute('activities', $this->activityRepository->get_by_user($detail));
            return $detail;
        });

        $activities=$this->activityRepository->all();
        $cities=$this->cityRepository->all();
        return view('user::admin.index', compact('users','tags','cities','activities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $roles = $this->roleRepository->all();
        return view('user::admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        if ($request->hasFile('image')) {
            $file_array = [
                'file' => $request->file('image'),
                'type' => 'image',
            ];
            $image = $this->mediaController->create($file_array, 'upload/user');
        }
        $user = $this->userRepository->create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'username' => $request->mobile,
            'password' => bcrypt($request->password),
            'mobile' => $request->mobile,
            'email' => $request->email,
            'nationalCode' => $request->nationalCode,
            'image_id' => $image ?? null,
            'create_user' => auth()->id(),
        ]);

        $user->roles()->sync($request->roles);
        toast('ثبت کاربر با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();
        return redirect()->route('user.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user=$this->userRepository->find($id);
        $user_activities =$this->activityRepository->get_by_user($user);
        return view('user::admin.show', compact('user','user_activities'));

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($user_id)
    {
        $user = $this->userRepository->find_with_trash($user_id);
        $roles = $this->roleRepository->all();
        $this_roles = $this->userRepository->get_roles($user_id)->pluck('id')->toArray();
        $activities =$this->activityRepository->all($user);
        $states=$this->stateRepository->all_has_city();
        $city=$this->cityRepository->find($user->city_id);
        $user_activities=$this->activityRepository->get_by_user($user);
        return view('user::admin.edit', compact('user', 'roles', 'this_roles','activities','states','city','user_activities'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update2(UserRequest $request, $user_id)
    {
        $user = $this->userRepository->find_with_trash($user_id);
        if ($request->hasFile('image')) {
            $file_array = [
                'file' => $request->file('image'),
                'type' => 'image',
            ];
            $image = $this->mediaController->create($file_array, 'upload/user');
        } else
            $image = $user->image_id;
        $this->userRepository->update($user, [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'username' => $request->mobile,
            'password' => $request->oldpassword ? $user->password : bcrypt($request->password),
            'mobile' => $request->mobile,
            'email' => $request->email,
            'nationalCode' => $request->nationalCode,
            'image_id' => $image,
            'update_user' => auth()->id(),
        ]);

        $user->roles()->sync($request->roles);
        toast('ویرایش کاربر با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();
        return redirect()->route('user.index');
    }
    public function update(UserRequest $request, $user_id)
    {
        $user = $this->userRepository->find_with_trash($user_id);

        if ($request->hasFile('image')) {
            $file_array = [
                'file' => $request->file('image'),
                'type' => 'image',
            ];
            $image = $this->mediaController->create($file_array, 'upload/user');
        } else
            $image = $user->image_id;
        if ($request->hasFile('company_logo')) {
            $file_array = [
                'file' => $request->file('company_logo'),
                'type' => 'image',
            ];
            $company_logo = $this->mediaController->create($file_array, 'upload/user');
        } else
            $company_logo = $user->company_logo;
        if ($request->hasFile('banner')) {
            $file_array = [
                'file' => $request->file('banner'),
                'type' => 'image',
            ];
            $banner = $this->mediaController->create($file_array, 'upload/user');
        } else
            $banner= $user->teacher_banner;
        if ($request->hasFile('teaser')) {
            $file_array = [
                'file' => $request->file('teaser'),
                'type' => 'image',
            ];
            $teaser = $this->mediaController->create($file_array, 'upload/user');
        } else
            $teaser = $user->teacher_teaser;
        $this->userRepository->update($user, [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'username' => $request->mobile,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'bornDate' => $this->create_born_date($request),
            'nationalCode' => $request->nationalCode,
            'image_id' => $image,
            'teacher_teaser'=>$teaser,
            'teacher_banner'=>$banner,
            'prefix'=>$request->prefix,
            'english_name'=>$request->english_name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'degree_of_education'=>$request->degree_of_education,
            'company_name'=>$request->company_name,
            'company_logo'=>$company_logo,
            'activity_id'=>isset($request->activities)?implode(',',$request->activities):null,
            'city_id'=>$request->city_id,
            'company_description'=>$request->company_description,
            'secret_description'=>$request->secret_description,
            'update_user' => auth()->id(),
            'password' => $request->oldpassword ? $user->password : bcrypt($request->password),

        ]);
            $user->roles()->sync($request->roles);

        toast('ویرایش پروفایل با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($user_id)
    {
        $user = $this->userRepository->find($user_id);
        $this->userRepository->delete($user);
        toast('حذف کاربر با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();
        return redirect()->route('user.index');
    }

    public function get_user_object(Request $request)
    {
        $user=$this->userRepository->find_with_trash($request->user_id);
        return response()->json($user);

    }
   public function inactive_users()
   {
       $users = $this->userRepository->all_inactive();
       $users->load('roles');
       return view('user::admin.inactive_users', compact('users'));
   }
   public function user_activation($user_id)
   {
       $user = $this->userRepository->find_with_trash($user_id);
        $this->userRepository->restore($user);
       toast('فعالسازی کاربر با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();

       return redirect()->route('inactive_users');

   }
    public function create_born_date($request)
    {
        if($request->day && $request->month && $request->year)
        {
            $day=strlen($request->day)<2?'0'.$request->day:$request->day;
            $month=strlen($request->month)<2?'0'.$request->month:$request->month;
            $year=$request->year;
            return  $year."-".$month."-".$day;
        } else
            return null;
    }

    private function get_tags($request)
    {
        $tags=[];
        if(isset($request->search))
            array_push($tags,$request->search);
        if(isset($request->city))
            array_push($tags," شهر : ".$this->cityRepository->find($request->city)->title);

        if(isset($request->activity))
            array_push($tags," حوزه : ".$this->activityRepository->find($request->activity)->title);
        if(isset($request->from))
            array_push($tags,"از تاریخ ".$request->from);
        if(isset($request->to))
            array_push($tags,"تا تاریخ ".$request->to);

        return $tags;
    }
}
