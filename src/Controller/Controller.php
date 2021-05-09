<?php

namespace Controller;

use Builder\Builder;
use Utility\ResponseWrapper;

class Controller extends BaseController
{
    public static function category()
    {
        try {
            $data = (new Builder())
                ->table('categories')
                ->get();

            return ResponseWrapper::successResponse($data);

        } catch (\Exception $e) {
            return ResponseWrapper::errorResponse($e->getMessage());

        }
    }

    public static function getDocuments()
    {
        $categoryId = $_GET['category_id'];

        try {
            $data = (new Builder())
                ->table('documents')
                ->where('category_id = ' . $categoryId)
                ->get();

            return ResponseWrapper::successResponse($data);

        } catch (\Exception $e) {
            return ResponseWrapper::errorResponse($e->getMessage());

        }
    }

    public static function showDocument()
    {
        $documentId = $_GET['document_id'];

        try {
            $data = (new Builder())
                ->table('documents')
                ->where('id = ' . $documentId)
                ->first();

            return ResponseWrapper::successResponse($data);

        } catch (\Exception $e) {
            return ResponseWrapper::errorResponse($e->getMessage());
        }
    }

    public static function createDocuments()
    {
        try {
            $postData = json_decode(file_get_contents('php://input'), true);

            if (empty($postData['name'])) return ResponseWrapper::validationErrorResponse("Name is required");
            if (empty($postData['category'])) return ResponseWrapper::validationErrorResponse("Category is required");

            $formData = [
                'name' => $postData['name'],
                'category_id' => $postData['category'],
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ];

            $data = (new Builder())
                ->table('documents')
                ->create($formData);

            return ResponseWrapper::successResponse($data);
        } catch (\Exception $e) {
            return ResponseWrapper::errorResponse($e->getMessage());
        }
    }

    public static function editDocuments()
    {
        try {

            $documentId = $_GET['document_id'];
            $postData = json_decode(file_get_contents('php://input'), true);

            if (empty($documentId)) return ResponseWrapper::errorResponse('No Id found for update');
            if (empty($postData['name'])) return ResponseWrapper::validationErrorResponse("Name is required");
            if (empty($postData['category'])) return ResponseWrapper::validationErrorResponse("Category is required");

            $formData = [
                'name' => $postData['name'],
                'category_id' => $postData['category']
            ];

            $data = (new Builder())
                ->table('documents')
                ->where('id = ' . $documentId)
                ->update($formData);

            return ResponseWrapper::successResponse($data);

        } catch (\Exception $e) {
            return ResponseWrapper::errorResponse($e->getMessage());
        }
    }
    public static function deleteDocuments()
    {
        try {

            $postData = json_decode(file_get_contents('php://input'), true);
            $documentId = $postData['document_id'];

            if (empty($documentId)) return ResponseWrapper::validationErrorResponse("No document id found");

            $data = (new Builder())
                ->table('documents')
                ->where('id = ' . $documentId)
                ->delete();

            return ResponseWrapper::successResponse(['success' => true]);

        } catch (\Exception $e) {
            return ResponseWrapper::errorResponse($e->getMessage());
        }
    }
}