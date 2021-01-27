<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Repositories\ContactRepository;
use App\Services\AwesomeCepApiService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    private $contactRepository;
    private $awesomeCepApiService;

    function __construct(ContactRepository $contactRepository, AwesomeCepApiService $awesomeCepApiService)
    {
        $this->contactRepository = $contactRepository;
        $this->awesomeCepApiService = $awesomeCepApiService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = $this->contactRepository->paginate(15);
        return response()->json($contacts, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactStoreRequest $request)
    {
        $data = $request->validated();
        $zipCode = $data['zip_code'];

        try {
            $addressData = $this->awesomeCepApiService->fetchZipCodeData($zipCode);

            if(!$addressData){
                return response()->json(['message'=> 'Invalid Zip Code.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $completeData = array_merge(
                $data,
                [
                    'street' => $addressData->address,
                    'state' => $addressData->state,
                    'neighborhood' => $addressData->district,
                    'city' => $addressData->city
                ]
            );

            $contact = $this->contactRepository->create($completeData);

            return response()->json(['data' => $contact], Response::HTTP_CREATED);
        } catch (ClientException $exception) {
            return response()->json(['message' => 'Zip Code not found', 'error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = $this->contactRepository->find($id);

        if(!$contact){
            return response()->json(
              ['message' => 'Resource not found'],
              Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(['data' => $contact], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactStoreRequest $request, $id)
    {
        $data = $request->validated();
        $zipCode = $data['zip_code'];

        try {
            $contact = $this->contactRepository->find($id);

            if(!$contact){
                return response()->json(
                  ['message' => 'Resource not found'],
                  Response::HTTP_NOT_FOUND
                );
            }

            $addressData = $this->awesomeCepApiService->fetchZipCodeData($zipCode);

            if(!$addressData){
                return response()->json(['message'=> 'Invalid Zip Code.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $completeData = array_merge(
                $data,
                [
                    'street' => $addressData->address,
                    'state' => $addressData->state,
                    'neighborhood' => $addressData->district,
                    'city' => $addressData->city
                ]
            );

            $contact->update($completeData);

            return response()->json(['data' => $contact], Response::HTTP_OK);
        } catch (ClientException $exception) {
            return response()->json(['message' => 'Zip Code not found', 'error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = $this->contactRepository->find($id);

        if(!$contact){
            return response()->json(
              ['message' => 'Resource not found'],
              Response::HTTP_NOT_FOUND
            );
        }

        $contact->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
