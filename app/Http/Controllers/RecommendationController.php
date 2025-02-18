<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Recommendation;
use App\Models\School;
use App\Models\SourceSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RecommendationController extends Controller
{
    public function __construct()
    {
        $this->middleware('register')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $identity = request('identity', 'all');
        $school = request('school', 'all');
        $source = request('source', 'all');
        $year = request('year', 'all');
        $reference = request('reference', 'all');

        $recommendationQuery = Recommendation::query();
        if (Auth::user()->role == 'A') {
            if ($identity !== 'all') {
                $recommendationQuery->whereHas('applicant', function ($query) use ($identity) {
                    $query->where('identity_user', $identity);
                });
            }
        } else if(Auth::user()->role == 'P') {
            $identity = Auth::user()->identity;
            $recommendationQuery->whereHas('applicant', function ($query) use ($identity) {
                $query->where('identity_user', $identity);
            });
        }

        if ($school !== 'all') {
            $recommendationQuery->where('school_id', $school);
        }

        if ($year !== 'all') {
            $recommendationQuery->where('year', $year);
        }

        if ($reference !== 'all') {
            $recommendationQuery->where('reference', 'like', '%' . $reference . '%');
        }

        if ($source !== 'all') {
            $recommendationQuery->where('source_id', $source);
        }

        $recommendations = $recommendationQuery->with(['applicant', 'schoolapplicant', 'applicant.presenter', 'sourcesetting'])->paginate(5);

        $users = User::where('role', 'P')->get();
        $schools = School::all();
        $sources = SourceSetting::all();
        return view('pages.recommendation.index')->with([
            'users' => $users,
            'schools' => $schools,
            'sources' => $sources,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $schools = School::all();
        return view('pages.recommendation.create')->with([
            'schools' => $schools
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name.*' => 'required|string|max:255',
            'phone.*' => 'required|string|min:13|max:14',
            'school_id.*' => 'required',
            'class.*' => 'required|string|max:255',
            'year.*' => 'required|integer|min:1900',
        ], [
            'name.*.required' => 'Nama wajib diisi',
            'phone.*.required' => 'Nomor telepon wajib diisi',
            'phone.*.min' => 'Nomor telepon minimal 13 karakter',
            'phone.*.max' => 'Nomor telepon maksimal 14 karakter',
            'school_id.*.required' => 'Sekolah wajib dipilih',
            'class.*.required' => 'Kelas wajib diisi',
            'class.*.max' => 'Kelas maksimal 255 karakter',
            'year.*.required' => 'Tahun wajib diisi',
            'year.*.integer' => 'Tahun harus berupa angka',
            'year.*.min' => 'Tahun minimal 1900',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $names = $request->input('name');
        $phones = $request->input('phone');
        $schools = $request->input('school_id');
        $classes = $request->input('class');
        $years = $request->input('year');

        $data = [];
        for ($i = 0; $i < count($names); $i++) {
            array_push($data, [
                'identity_user' => Auth::user()->identity,
                'name' => $names[$i],
                'phone' => $phones[$i],
                'school_id' => $schools[$i],
                'class' => $classes[$i],
                'year' => $years[$i],
                'source_id' => 8,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
            ]);
        }
        Recommendation::insert($data);
        return back()->with('message', 'Data rekomendasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::where('identity', $id)->first();
        $applicant = Applicant::where('identity', $id)->first();
        $presenter = $applicant->identity_user;
        $schools = School::all();
        $recommendationQuery = Recommendation::query();

        $recommendationQuery->whereHas('applicant', function ($query) use ($presenter, $id) {
            $query->where('identity_user', $presenter);
            $query->where('identity', $id);
        });

        $recommendations = $recommendationQuery->get();
        return view('pages.recommendation.show')->with([
            'user' => $user,
            'recommendations' => $recommendations,
            'schools' => $schools,
            'applicant' => $applicant
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $data = Recommendation::where('id', $id)->first();
        $schools = School::all();
        return view('pages.recommendation.edit')->with([
            'data' => $data,
            'schools' => $schools
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name.*' => 'required|string|max:255',
            'phone.*' => 'required|string|min:13|max:14',
            'school_id.*' => 'required|exists:schools,id',
            'class.*' => 'required|string|max:255',
            'year.*' => 'required|integer|min:1900',
        ], [
            'name.*.required' => 'Nama wajib diisi',
            'phone.*.required' => 'Nomor telepon wajib diisi',
            'phone.*.min' => 'Nomor telepon minimal 13 karakter',
            'phone.*.max' => 'Nomor telepon maksimal 14 karakter',
            'school_id.*.required' => 'Sekolah wajib dipilih',
            'school_id.*.exists' => 'Sekolah tidak valid',
            'class.*.required' => 'Kelas wajib diisi',
            'class.*.max' => 'Kelas maksimal 255 karakter',
            'year.*.required' => 'Tahun wajib diisi',
            'year.*.integer' => 'Tahun harus berupa angka',
            'year.*.min' => 'Tahun minimal 1900',
        ]);

        $recommendation = Recommendation::findOrFail($id);

        $names = $request->input('name');
        $phones = $request->input('phone');
        $schools = $request->input('school_id');
        $classes = $request->input('class');
        $years = $request->input('year');

        $data = [
            'identity_user' => Auth::user()->identity,
            'name' => $names[0],
            'phone' => $phones[0],
            'school_id' => $schools[0],
            'class' => $classes[0],
            'year' => $years[0],
            'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
        ];

        $recommendation->update($data);
        return back()->with('message', 'Data rekomendasi berhasil diubah!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_admin(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:13|max:14',
            'school_id' => 'required|exists:schools,id',
            'class' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2500',
            'parent_phone' => 'max:14',
        ], [
            'name.required' => 'Nama wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.min' => 'Nomor telepon minimal 13 karakter',
            'phone.max' => 'Nomor telepon maksimal 14 karakter',
            'school_id.required' => 'Sekolah wajib dipilih',
            'school_id.exists' => 'Sekolah tidak valid',
            'class.required' => 'Kelas wajib diisi',
            'class.max' => 'Kelas maksimal 255 karakter',
            'year.required' => 'Tahun wajib diisi',
            'year.integer' => 'Tahun harus berupa angka',
            'year.min' => 'Tahun minimal 1900',
            'year.max' => 'Tahun maksimal 2500',
            'parent_phone.max' => 'Nomor telepon orang tua maksimal 14 karakter',
        ]);

        $recommendation = Recommendation::findOrFail($id);

        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'school_id' => $request->input('school_id'),
            'class' => $request->input('class'),
            'year' => $request->input('year'),
            'plan' => $request->input('plan'),
            'parent_phone' => $request->input('parent_phone'),
            'parent_job' => $request->input('parent_job'),
            'income_parent' => $request->input('income_parent'),
            'address' => $request->input('address'),
            'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
        ];

        $recommendation->update($data);
        return back()->with('message', 'Data rekomendasi berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $recommendation = Recommendation::findOrFail($id);
        $recommendation->delete();

        return back()->with('message', 'Data rekomendasi berhasil dihapus!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_status(Request $request, $id): RedirectResponse
    {
        $recommendation = Recommendation::findOrFail($id);
        $data = [
            'status' => $request->input('status'),
        ];
        $recommendation->update($data);

        return back()->with('message', 'Data rekomendasi berhasil diubah!');
    }
}
