<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Analisis extends Model
{
    
    protected $table = 'analisis'; // Jika nama tabel tidak plural

    /**
     * Mass assignable fields
     * Kolom yang bisa diisi secara massal
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'kategori_id',
        'user_id'
    ];

    /**
     * Casting tipe data
     * Untuk konversi otomatis tipe data kolom
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'metadata' => 'array' // Jika ada kolom JSON
    ];

    /**
     * Kolom tanggal otomatis
     * (default created_at dan updated_at)
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at' // Jika menggunakan soft delete
    ];

    /**
     * Non-aktifkan timestamp
     * Jika tabel tidak memiliki kolom created_at dan updated_at
     */
    // public $timestamps = false;

    /**
     * Primary key kustom
     * Jika tidak menggunakan id sebagai primary key
     */
    // protected $primaryKey = 'kode_analisis';
    
    /**
     * Tipe primary key
     * Jika menggunakan UUID atau tipe lain
     */
    // protected $keyType = 'string';

    /**
     * Relasi dengan model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan model Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriAnalisis::class, 'kategori_id');
    }

    /**
     * Relasi dengan model HasilAnalisis
     */
    public function hasilAnalisis()
    {
        return $this->hasMany(HasilAnalisis::class);
    }

    /**
     * Scope untuk analisis aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Accessor untuk format tanggal
     */
    public function getTanggalMulaiFormatAttribute()
    {
        return $this->tanggal_mulai->format('d F Y');
    }

    /**
     * Mutator untuk judul
     */
    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucwords(strtolower($value));
    }

    /**
     * Validasi dasar
     */
    public static function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ];
    }
}