<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    // Метод для отображения информации о сервере
    public function serverInfo()
    {
        ob_start(); // Начинаем буферизацию вывода
        phpinfo();  // Вызываем phpinfo()
        $phpinfo = ob_get_clean(); // Получаем содержимое буфера и очищаем его

        return response($phpinfo, 200)
                ->header('Content-Type', 'text/html'); // Устанавливаем заголовок Content-Type
    }

    // Метод для отображения информации о клиенте
        // Метод для отображения информации о клиенте
    public function clientInfo(Request $request)
    {
        // Получаем IP-адрес клиента из запроса
        $ip = $request->ip();
        
        // Получаем User-Agent клиента из заголовков запроса
        $userAgent = $request->header('User-Agent');
        
        // Возвращаем данные о клиенте в формате JSON
        return response()->json(['ip' => $ip, 'userAgent' => $userAgent]);
    }

    // Метод для отображения информации о базе данных
    public function databaseInfo()
    {
        try {
            // Пытаемся получить соединение с базой данных
            $connection = DB::connection()->getPdo();
            
            // Получаем имя базы данных
            $dbName = DB::connection()->getDatabaseName();
            
            // Возвращаем информацию о базе данных в формате JSON
            return response()->json(['database' => $dbName, 'connection' => $connection->getAttribute(\PDO::ATTR_CONNECTION_STATUS)]);
        } catch (\Exception $e) {
            // Если возникла ошибка при подключении к базе данных, возвращаем сообщение об ошибке в формате JSON
            return response()->json(['error' => 'Could not connect to the database.'], 500);
        }
    }

}
