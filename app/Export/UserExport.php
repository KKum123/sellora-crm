<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\PUser;

class UserExport extends Model
{
    public function model(array $row)
    {
        return new PUser([
            'name' => $row[0]
        ]);
    }
}