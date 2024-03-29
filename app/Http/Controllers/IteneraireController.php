<?php

namespace App\Http\Controllers;
use App\Models\Destination;
use App\Models\Itineraire;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
class IteneraireController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $itineraires = $user->itineraires()->with('destinations')->get();
        return response()->json([
            'status' => 'success',
            'itineraires' => $itineraires,
        ]);
    }



   /**
 * Retrieve all itineraries with destinations.
 *
 * @OA\Get(
 *     path="/api/itineraries",
 *     summary="Retrieve all itineraries with destinations",
 *     tags={"Itineraries"},
 *     @OA\Response(
 *         response=200,
 *         description="Itineraries retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="itineraries",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="id",
 *                         type="integer"
 *                     ),
 *                     @OA\Property(
 *                         property="title",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="category",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="image",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="start",
 *                         type="string",
 *                         format="date"
 *                     ),
 *                     @OA\Property(
 *                         property="end",
 *                         type="string",
 *                         format="date"
 *                     ),
 *                     @OA\Property(
 *                         property="duration",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="destinations",
 *                         type="array",
 *                         @OA\Items(
 *                             type="object",
 *                             @OA\Property(
 *                                 property="id",
 *                                 type="integer"
 *                             ),
 *                             @OA\Property(
 *                                 property="name",
 *                                 type="string"
 *                             ),
 *                             @OA\Property(
 *                                 property="logement",
 *                                 type="string"
 *                             ),
 *                             @OA\Property(
 *                                 property="list",
 *                                 type="string"
 *                             )
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     )
 * )
 */

    public function indexAll()
    {
        $itineraires = Itineraire::with('destinations')->get();

        return response()->json([
            'status' => 'success',
            'itineraires' => $itineraires,
        ]);
    }


/**
 * Store a new itinerary with destinations.
 *
 * @OA\Post(
 *     path="/api/itineraries",
 *     summary="Store a new itinerary with destinations",
 *     tags={"Itineraries"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Itinerary details with destinations",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"title", "category", "image", "start", "end", "duration", "destinations"},
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     example="Amazing Trip to Morocco"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string",
 *                     example="Adventure"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     example="https://example.com/image.jpg"
 *                 ),
 *                 @OA\Property(
 *                     property="start",
 *                     type="string",
 *                     format="date",
 *                     example="2024-04-01"
 *                 ),
 *                 @OA\Property(
 *                     property="end",
 *                     type="string",
 *                     format="date",
 *                     example="2024-04-10"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="string",
 *                     example="10 days"
 *                 ),
 *                 @OA\Property(
 *                     property="destinations",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         required={"name", "logement", "list"},
 *                         @OA\Property(
 *                             property="name",
 *                             type="string",
 *                             example="Marrakech"
 *                         ),
 *                         @OA\Property(
 *                             property="logement",
 *                             type="string",
 *                             example="Luxury Hotel"
 *                         ),
 *                         @OA\Property(
 *                             property="list",
 *                             type="string",
 *                             example="Visit Jemaa el-Fnaa square, explore the souks"
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Itinerary created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Itinerary with destinations created successfully"
 *             ),
 *             @OA\Property(
 *                 property="itineraire",
 *                 type="object",
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="start",
 *                     type="string",
 *                     format="date"
 *                 ),
 *                 @OA\Property(
 *                     property="end",
 *                     type="string",
 *                     format="date"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="user_id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="destinations",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(
 *                             property="name",
 *                             type="string"
 *                         ),
 *                         @OA\Property(
 *                             property="logement",
 *                             type="string"
 *                         ),
 *                         @OA\Property(
 *                             property="list",
 *                             type="string"
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Validation error"
 *             ),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 description="Validation errors",
 *                 example={
 *                     "title": {"The title field is required."},
 *                     "category": {"The category field is required."},
 *                     "image": {"The image field is required."},
 *                     "start": {"The start field is required."},
 *                     "end": {"The end field is required."},
 *                     "duration": {"The duration field is required."},
 *                     "destinations": {"The destinations field is required."}
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="An error occurred"
 *             ),
 *             @OA\Property(
 *                 property="error",
 *                 type="string"
 *             )
 *         )
 *     )
 * )
 */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'image' => 'required|string',
                'start' => 'required',
                'end' => 'required',
                'duration' => 'required|string',
                'destinations' => 'required|array|min:2',
                'destinations.*.name' => 'required|string|max:255',
                'destinations.*.logement' => 'required|string|max:255',
                'destinations.*.list' => 'required|string|max:255',
            ]);


            $itineraire = Itineraire::create([
                'title' => $request->title,
                'category' => $request->category,
                'image' => $request->image,
                'start' => $request->start,
                'end' => $request->end,
                'duration' => $request->duration,
                'user_id' => $user->id,
            ]);

            $destinations = [];
            foreach ($request->destinations as $destinationData) {
                $destination = Destination::create([
                    'name' => $destinationData['name'],
                    'logement' => $destinationData['logement'],
                    'list' => $destinationData['list'],
                    'itineraire_id' => $itineraire->id,
                ]);
                $destinations[] = $destination;
            }

            $itineraire['destinations'] = $destinations;

            return response()->json([
                'status' => 'success',
                'message' => 'Itinéraire avec ses destinations créé avec succès',
                'itineraire' => $itineraire,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
 * Delete an itinerary.
 *
 * @OA\Delete(
 *     path="/api/itineraries/{id}",
 *     summary="Delete an itinerary",
 *     tags={"Itineraries"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the itinerary to delete",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Itinerary deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Itinéraire supprimé avec succès."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Vous n'êtes pas autorisé à supprimer cet itinéraire."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not found",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Itinéraire non trouvé."
 *             )
 *         )
 *     )
 * )
 */


    public function destroy($id)
    {
        $itineraire = Itineraire::find($id);

        if (!$itineraire) {
            return response()->json([
                'status' => 'error',
                'message' => 'Itinéraire non trouvé.',
            ], 404);
        }

        // dd(auth()->id());
        if ($itineraire->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'êtes pas autorisé à supprimer cet itinéraire.',
            ], 403);
        }

        $itineraire->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Itinéraire supprimé avec succès.',
        ]);
    }

    public function update(Request $request, $id)
    {

        $user = JWTAuth::parseToken()->authenticate();
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'image' => 'required|string',
                'start' => 'required',
                'end' => 'required',
                'duration' => 'required|string',
                'destinations' => 'required|array|min:2',
                'destinations.*.nom' => 'required|string|max:255',
                'destinations.*.logement' => 'required|string|max:255',
                'destinations.*.liste' => 'required|string|max:255',
            ]);

            $itineraire = Itineraire::find($id);

            if (!$itineraire) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Itinéraire non trouvé.',
                ], 404);
            }

            if ($itineraire->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vous n\'êtes pas autorisé à modifier cet itinéraire.',
                ], 403);
            }

            $itineraire->update([
                'title' => $request->title,
                'category' => $request->category,
                'image' => $request->image,
                'start' => $request->start,
                'end' => $request->end,
                'duration' => $request->duration,
            ]);

            $destinations = [];
            foreach ($request->destinations as $destinationData) {
                if (isset($destinationData['id'])) {

                    $destination = Destination::where('itineraire_id', $itineraire->id)
                        ->where('id', $destinationData['id'])
                        ->first();

                    if ($destination) {
                        $destination->update([
                            'name' => $destinationData['name'],
                            'logement' => $destinationData['logement'],
                            'list' => $destinationData['list'],
                        ]);
                        $destinations[] = $destination;
                    }

                } else {
                    $destination = Destination::create([
                        'name' => $destinationData['name'],
                        'logement' => $destinationData['logement'],
                        'list' => $destinationData['list'],
                        'itineraire_id' => $itineraire->id,
                    ]);
                }
                $destinations[] = $destination;
            }

            $itineraire['destinations'] = $destinations;

            return response()->json([
                'status' => 'success',
                'message' => 'Itinéraire avec ses destinations modifié avec succès',
                'itineraire' => $itineraire,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


/**
 * Search itineraries by title.
 *
 * @OA\Post(
 *     path="/api/itineraries/search",
 *     summary="Search itineraries by title",
 *     tags={"Itineraries"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Search query",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"title"},
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     example="Amazing Trip"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Itineraries retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="itineraries",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="id",
 *                         type="integer"
 *                     ),
 *                     @OA\Property(
 *                         property="title",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="category",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="image",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="start",
 *                         type="string",
 *                         format="date"
 *                     ),
 *                     @OA\Property(
 *                         property="end",
 *                         type="string",
 *                         format="date"
 *                     ),
 *                     @OA\Property(
 *                         property="duration",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="destinations",
 *                         type="array",
 *                         @OA\Items(
 *                             type="object",
 *                             @OA\Property(
 *                                 property="name",
 *                                 type="string"
 *                             ),
 *                             @OA\Property(
 *                                 property="logement",
 *                                 type="string"
 *                             ),
 *                             @OA\Property(
 *                                 property="list",
 *                                 type="string"
 *                             )
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="The title field is required."
 *             )
 *         )
 *     )
 * )
 */


    public function searchByTitre(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $titre = $request->input('title');

        $itineraires = Itineraire::where('title', 'like', "%$titre%")->get();

        return response()->json([
            'status' => 'success',
            'itineraires' => $itineraires,
        ]);
    }

/**
 * Filter itineraries by category and/or duration.
 *
 * @OA\Post(
 *     path="/api/itineraries/filter",
 *     summary="Filter itineraries by category and/or duration",
 *     tags={"Itineraries"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=false,
 *         description="Filter criteria",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="category",
 *                     type="string",
 *                     description="Category to filter by"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="string",
 *                     description="Duration to filter by"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Filtered itineraries retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="itineraries",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="id",
 *                         type="integer"
 *                     ),
 *                     @OA\Property(
 *                         property="title",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="category",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="image",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="start",
 *                         type="string",
 *                         format="date"
 *                     ),
 *                     @OA\Property(
 *                         property="end",
 *                         type="string",
 *                         format="date"
 *                     ),
 *                     @OA\Property(
 *                         property="duration",
 *                         type="string"
 *                     ),
 *                     @OA\Property(
 *                         property="destinations",
 *                         type="array",
 *                         @OA\Items(
 *                             type="object",
 *                             @OA\Property(
 *                                 property="name",
 *                                 type="string"
 *                             ),
 *                             @OA\Property(
 *                                 property="logement",
 *                                 type="string"
 *                             ),
 *                             @OA\Property(
 *                                 property="list",
 *                                 type="string"
 *                             )
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="The category must be a string."
 *             )
 *         )
 *     )
 * )
 */

    public function filter(Request $request)
    {
        $request->validate([
            'category' => 'sometimes|string|max:255',
            'duration' => 'sometimes|string|max:255',
        ]);

        $categorie = $request->input('category');
        $duree = $request->input('duration');

        $query = Itineraire::query();

        if ($categorie) {
            $query->where('category', $categorie);
        }

        if ($duree) {
            $query->where('duration', $duree);
        }

        $itineraires = $query->get();

        return response()->json([
            'status' => 'success',
            'itineraires' => $itineraires,
        ]);
    }


}