<?php
    use Zend\Code\Generator\ValueGenerator;
    
    use Illuminate\Support\Str;
    
    if (!function_exists('result')) {
        function result($results = [], $type, $code = 200)
        {
            return response(compact('results', 'type', 'code'), $code);
        }
    }
    
    
    if (!function_exists('check_base64_image')) {
        function check_base64_image($base64)
        {
            try {
                $img = imagecreatefromstring(base64_decode($base64));
                if (!$img) {
                    return false;
                }
                
                imagepng($img, 'tmp.png');
                $info = getimagesize('tmp.png');
                
                unlink('tmp.png');
                
                if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
                    return true;
                }
                
                return false;
            } catch (Exception $exception) {
                return false;
            }
        }
    }
    
    if (!function_exists('base64toImage')) {
        function base64toImage($base64File, $quality = 70, $folder = 'users')
        {
            if (!base64_decode($base64File, true)) {
                return null;
            }
            
            $storage = base_path('storage/app/' . $folder);
            $link = base_path('public/' . $folder);
            if (!file_exists($storage)) {
                mkdir($storage, 0755, true);
                link($storage, $link);
            }
            $fileName = Str::random(64) . ".jpg";
            $image = app('image')->make($base64File);
            $image->save($storage . DIRECTORY_SEPARATOR . $fileName, $quality);
            
            return $folder . DIRECTORY_SEPARATOR . $fileName;
        }
    }
    
    if (!function_exists('export')) {
        function export($expression)
        {
            $generator = new ValueGenerator($expression, ValueGenerator::TYPE_ARRAY_SHORT);
            $generator->setIndentation('  '); // 2 spaces
            return $generator->generate();
        }
    }
    
    /***
    if (!function_exists('can')) {
        function can($permissions)
        {
            $user = app(\Illuminate\Http\Request::class)->user();
            return $user->can($permissions);
        }
    }
    */
    
    if (!function_exists('upload')) {
        function upload(\Illuminate\Http\UploadedFile $file, $module = "hotels")
        {
            $storagePath = storage_path('app/' . $module);
            $publicPath = base_path('public/' . $module);
            
            if (!file_exists($storagePath)) {
                if (file_exists($publicPath)) {
                    unlink($publicPath);
                }
                mkdir($storagePath, 0755, true);
                link($storagePath, $publicPath);
            }
            
            if (!file_exists($publicPath)) {
                link($storagePath, $publicPath);
            }
            
            $fileName = Str::random(32) . ".jpg";
            
            $image = app('image')->make($file);
            
            $image->save($storagePath . DIRECTORY_SEPARATOR . $fileName, 75);
            
            return $module . DIRECTORY_SEPARATOR . $fileName;
        }
    }
