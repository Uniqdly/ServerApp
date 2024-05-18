<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    // Метод для отображения информации о сервере
    public function serverInfo()
    {
        ob_start(); // Начинаем буферизацию вывода
        phpinfo();  // Вызываем phpinfo()
        $phpinfo = ob_get_clean(); // Получаем содержимое буфера и очищаем его

        // Возвращаем содержимое phpinfo() в виде JSON
        return response()->json(['phpinfo' => $phpinfo]);
    }

    // Метод для отображения информации о клиенте
    public function clientInfo(Request $request)
    {
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        return response()->json(['ip' => $ip, 'userAgent' => $userAgent]);
    }

    // Метод для отображения информации о базе данных
    public function databaseInfo()
    {
        try {
            $connection = DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();
            return response()->json(['database' => $dbName, 'connection' => $connection->getAttribute(\PDO::ATTR_CONNECTION_STATUS)]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not connect to the database.'], 500);
        }
    }
}

