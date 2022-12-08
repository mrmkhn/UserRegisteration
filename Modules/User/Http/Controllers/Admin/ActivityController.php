<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ACL\Repositories\RoleRepository;
use Modules\Media\Http\Controllers\MediaController;
use Modules\User\Http\Requests\ActivityRequest;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Repositories\ActivityRepository;
use Modules\User\Repositories\UserRepository;

class ActivityController extends Controller
{
    private $activityRepository;
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $activities = $this->activityRepository->all();
        return view('user::admin.activity.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::admin.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ActivityRequest $request)
    {
        $this->activityRepository->create([
            'title' => $request->title,

        ]);
        toast('ثبت  با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();
        return redirect()->route('activity.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
//        return view('user::admin.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($activity_id)
    {
        $activity = $this->activityRepository->find($activity_id);
        return view('user::admin.activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ActivityRequest $request, $activity_id)
    {
        $activity = $this->activityRepository->find($activity_id);

        $this->activityRepository->update($activity, [
            'title' => $request->title,
        ]);
        toast('ویرایش  با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();
        return redirect()->route('activity.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($activity_id)
    {
        $activity = $this->activityRepository->find($activity_id);
        $this->activityRepository->delete($activity);
        toast('حذف با موفقیت انجام شد', 'success')->background('#e6ffe6')->timerProgressBar();
        return redirect()->route('activity.index');
    }


}
