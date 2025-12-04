<?php

namespace app\controller;

use support\Request;
use support\Response;

class MorckConfigController
{
    /**
     * 加载并返回JSON配置文件
     * @param Request $request
     * @return Response
     */
    public function getConfig(Request $request): Response
    {
        // 1. 定义JSON文件路径（使用webman的根目录辅助函数base_path()）
        // 假设JSON文件放在项目根目录的configs文件夹下（需自行创建）
        $jsonPath = base_path() . '/configs/config.json';

        // 2. 检查文件是否存在
        if (!file_exists($jsonPath)) {
            return response()->json([
                'error' => '配置文件不存在'
            ], 404); // 返回404状态码
        }

        // 3. 读取文件内容
        $jsonContent = file_get_contents($jsonPath);
        if ($jsonContent === false) {
            return response()->json([
                'error' => '无法读取配置文件'
            ], 500); // 返回500状态码
        }

        // 4. 验证JSON格式（可选）
        $jsonData = json_decode($jsonContent);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'error' => 'JSON格式无效: ' . json_last_error_msg()
            ], 500);
        }

        // 5. 返回JSON响应（webman会自动设置Content-Type为application/json）
        return response($jsonContent);
    }
}
