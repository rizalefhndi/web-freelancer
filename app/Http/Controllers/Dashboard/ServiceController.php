<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use File;
use Auth;

use App\Models\Service;
use App\Models\AdvantageService;
use App\Models\Tagline;
use App\Models\AdvantageUser;
use App\Models\ThumbnailService;
use App\Models\Order;
use App\Models\User;


class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('users_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('pages.dashboard.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->all();
        $data['users_id'] = Auth::user()->id;

        // Add to service
        $service = Service::create($data);

        // Add to advantage service
        foreach ($data['advantage-service'] as $key => $value) {
            $advantage_service = new AdvantageService();
            $advantage_service->service_id = $service->id;
            $advantage_service->advantage = $value;
            $advantage_service->save();
        }

        // Add to advantage user
        foreach ($data['advantage-user'] as $key => $value) {
            $advantage_user = new AdvantageUser();
            $advantage_user->service_id = $service->id;
            $advantage_user->advantage = $value;
            $advantage_user->save();
        }

        // Add to thumbnail service
        if ($request->hasFile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file) {
                $path = $file->store(
                    'assets/service/thumbnail' . 'public',
                );

                $thumbnail_service = new ThumbnailService();
                $thumbnail_service->service_id = $service['id'];
                $thumbnail_service->thumbnail = $path;
                $thumbnail_service->save();
            }
        }

        // Add to tagline
        foreach ($data['tagline'] as $key => $value) {
            $tagline = new Tagline();
            $tagline->service_id = $service->id;
            $tagline->tagline = $value;
            $tagline->save();
        }

        toast()->success('Save has been success');

        return redirect()->route('member.service.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $advantage_service = AdvantageService::where('service_id', $service['id'])->get();
        $tagline = Tagline::where('service_id', $service['id'])->get();
        $advantage_user = AdvantageUser::where('service_id', $service['id'])->get();
        $thumbnail_service= ThumbnailService::where('service_id', $service['id'])->get();

        return view('pages.dashboard.service.edit', compact('service', 'advantage_service', 'tagline', 'advantage_user', 'thumbnail_service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->all();

        // Update service
        $service->update($data);

        // Update advantage service
        foreach ($data['advantage-service'] as $key => $value) {
            $advantage_service = AdvantageService::find($key);
            $advantage_service->advantage = $value;
            $advantage_service->save();
        }

        // Add new advantage service
        if(isset($data['advantage_service'])) {
            foreach ($data['advantage-service'] as $key => $value) {
                $advantage_service = AdvantageService::find($key);
                $advantage_service->service_id = $service['id'];
                $advantage_service->advantage_id = $value;
                $advantage_service->save();
            }
        }

        // Update advantage user
        foreach ($data['advantage-user'] as $key => $value) {
            $advantage_user = AdvantageUser::find($key);
            $advantage_user->advantage = $value;
            $advantage_user->save();
        }

        // Add new advantage user
        if(isset($data['advantage_user'])) {
            foreach ($data['advantage-user'] as $key => $value) {
                $advantage_user = AdvantageUser::find($key);
                $advantage_user->service_id = $service['id'];
                $advantage_user->advantage = $value;
                $advantage_user->save();
            }
        }

          // Update advantage tagline
        foreach ($data['tagline'] as $key => $value) {
            $tagline = Tagline::find($key);
            $tagline->tagline = $value;
            $tagline->save();
        }

        // Add new advantage tagline
        if(isset($data['tagline'])) {
            foreach ($data['tagline'] as $key => $value) {
                $tagline = Tagline::find($key);
                $tagline->service_id = $service['id'];
                $tagline->tagline = $value;
                $tagline->save();
            }
        }

        // Update thumbnail service
        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $key => $value)
                {
                    $get_photo = ThumbnailService::where('id', $key)->first();

                    $path = $file->store(
                        'assets/service/thumbnail' . 'public',
                    );

                    $thumbnail_service = ThumbnailService::find($key);
                    $thumbnail_service->thumbnail = $path;
                    $thumbnail_service->save();

                    $data = 'storage/'.$get_photo['photo'];
                    if(File::exists($data)) {
                        File::delete($data);
                    } else {
                        File::delete('storage/app/public/'.$get_photo['photo']);
                    }
            }
        }

        // Add new thumbnail service
        if ($request->hasFile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file)
                {
                    $path = $file->store(
                        'assets/service/thumbnail' . 'public',
                    );

                    $thumbnail_service = new ThumbnailService();
                    $thumbnail_service->service_id = $service['id'];
                    $thumbnail_service->thumbnail = $path;
                    $thumbnail_service->save();
                }
        }

        toast()->success('Update has been success');

        return redirect()->route('member.service.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return abort(404);
    }
}
