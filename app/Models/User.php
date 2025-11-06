<?php
    namespace App\Models;
    // Use the standard User model definition, adjusting only to match your fields.
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    class User extends Authenticatable
    {
        use HasFactory, Notifiable;
        
        protected $fillable = [
            'nama',
            'email',
            'password',
            'role', // Added 'role' to the fillable fields
        ];
        protected $hidden = [
            'password',
            'remember_token',
        ];
        
        protected $casts = [
            // Cast the 'role' attribute to an enum or string, if needed.
            // For simple ENUM, string casting is usually sufficient.
            'role' => 'string', 
            'email_verified_at' => 'datetime',
        ];
        
        /**
        * Check if the user is an admin.
        *
        * @return bool
        */
        public function isAdmin()
        {
            return $this->role === 'admin';
        }
    }