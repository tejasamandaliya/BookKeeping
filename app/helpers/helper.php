<?php

function sendResponse($result,  $message = null, $success = true, $code = 200)
{
    return response()->json([
        'data' => $result,
        'success' => $success,
        'message' => $message,
    ], $code);
}

function sendErrorResponse($errors, $message = null, $code = 422)
{
    return response()->json([
        'message' => $message,
        'errors' => $errors,
    ], $code);
}

function sendError($error, $code = 422)
{
    return response()->json([
        'message' => $error,
    ], $code);
}

function sendSuccess($message)
{
    return response()->json([
        'success' => true,
        'message' => $message,
    ], 200);
}
