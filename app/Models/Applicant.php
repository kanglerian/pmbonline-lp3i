<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity',
        'pmb',

        'nik',
        'name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'religion',
        'address',
        'social_media',

        'email',
        'phone',

        'education',
        'school',
        'major',
        'class',
        'year',
        'achievement',
        'kip',
        'nisn',

        'schoolarship',
        'scholarship_date',
        'scholarship_type',

        'note',
        'relation',

        'identity_user',
        'program',
        'program_second',
        'isread',
        'come',

        'is_applicant',
        'is_daftar',
        'is_register',

        'known',
        'planning',
        'other_campus',
        'income_parent',

        'place_of_working',

        'followup_id',
        'programtype_id',
        'source_daftar_id',
        'source_id',
        'status_id',
    ];


    protected $table = 'applicants';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    public function userupload()
    {
        return $this->belongsTo(UserUpload::class, 'identity_user', 'identity');
    }

    public function presenter()
    {
        return $this->belongsTo(User::class, 'identity_user', 'identity');
    }

    public function sourceSetting()
    {
        return $this->belongsTo(SourceSetting::class, 'source_id', 'id');
    }
    public function sourceDaftarSetting()
    {
        return $this->belongsTo(SourceSetting::class, 'source_daftar_id', 'id');
    }

    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'programtype_id', 'id');
    }

    public function applicantStatus()
    {
        return $this->belongsTo(ApplicantStatus::class, 'status_id', 'id');
    }

    public function SchoolApplicant()
    {
        return $this->belongsTo(School::class, 'school', 'id');
    }

    public function histories()
    {
        return $this->belongsTo(ApplicantHistory::class, 'identity_user', 'identity');
    }

    public function father()
    {
        return $this->hasOne(ApplicantFamily::class, 'identity_user', 'identity')->where('gender', 1);
    }

    public function mother()
    {
        return $this->hasOne(ApplicantFamily::class, 'identity_user', 'identity')->where('gender', 0);
    }

    public function FollowUp()
    {
        return $this->belongsTo(FollowUp::class, 'followup_id', 'id');
    }

    public function registration()
    {
        return $this->hasOne(StatusApplicantsRegistration::class, 'identity_user', 'identity');
    }

    public function enrollment()
    {
        return $this->hasOne(StatusApplicantsEnrollment::class, 'identity_user', 'identity');
    }

    public function integration()
    {
        return $this->hasOne(Integration::class, 'identity_user', 'identity');
    }

    public function event()
    {
        return $this->hasOne(EventDetail::class, 'identity_user', 'identity');
    }

}
