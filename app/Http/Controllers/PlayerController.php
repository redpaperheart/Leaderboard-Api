<?php

namespace App\Http\Controllers;

use App\Player;
//use App\Http\Requests;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class PlayerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPlayer($pId)
    {
        // ->limit(10)
        $player = Player::findOrFail($pId);
        return response()->json( $player );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPlayers(Request $request, $id, $amt = null)
    {

        // ->limit(10)
        $players = Player::where('leaderboard', '=', $id)
                    ->orderBy('score', 'DESC')
                    ->orderBy('created_at', 'DESC');
        if( $amt &&  intval($amt) ){
            $players->limit($amt);
        }
        $players = $players->get();
        return response()->json( $players );
    }

    //lb/{lbId}/with/{pId}/{amt}','PlayerController@getPlayersWith

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPlayersWith(Request $request, $lbId, $pId, $amt)
    {
        $players = Player::where('leaderboard', '=', $lbId)
                    ->orderBy('score', 'DESC')
                    ->orderBy('created_at', 'DESC');
        if( $amt &&  intval($amt) ){
            $players->limit($amt);
        }
        $players = $players->get();
        $includes = false;
        foreach($players as $player){
          if($player->id == $pId){
            $includes = true;
            break;
          }
        }
        if(!$includes){
          $player = Player::findOrFail($pId);
          $players[] = $player;
        }
        return response()->json( $players );
    }

    /**
     * Save a new article
     *
     * @param PostRequest $request
     * @return Response
    */
    public function createPlayer( Request $request )
    {
        $this->validate($request, [
            'leaderboard' => 'required | string',
            'name' => 'required | string',
            'score' => 'required|numeric',
            'image' => 'image'
        ]);

        //dd( $request->all() );
        $r = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {


            //$fileName = Player::getUniqueFilename('png');
            $fileName = time().'_'.Player::getUniqueFilename($request->image->extension());
            //$destinationPath = 'data/images/'

            $path = storage_path().'/app/public/images';
            //$path = public_path().'storage/images';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            };

            $request->file('image')->move($path, $fileName);

            $r['image'] = 'images/'.$fileName;

        }
        $player = Player::create( $r );

        $this->recalculateLeaderboardPostions( $player );

        $player = Player::find($player->id);

        //dd($player);
        return response()->json( $player );
    }

    public function recalculateLeaderboardPostions( $player ){

        $scores = Player::where('leaderboard', '=', $player->leaderboard)
                    //->where('score', '<=', $player->score)
                    ->orderBy('score', 'DESC')
                    ->distinct()
                    ->get(['score']);

        $i = 1;
        $rank;
        foreach( $scores as $score ){
            $rank[$score->score] = $i;
            $i++;
        }
        //dd($scores);
        $players = Player::where('leaderboard', '=', $player->leaderboard)
                    ->where('score', '<=', $player->score)
                    ->get();
        foreach( $players as $p ){
            $p->rank = $rank[$p->score];
            $p->save();
        }

        return response()->json( $players );
    }

    public function calculateAllLeaderboardPostions( $lb ){
        $scores = Player::where('leaderboard', '=', $lb)
                    ->orderBy('score', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->distinct()
                    ->get(['score']);

        $i = 1;
        $rank;
        foreach( $scores as $score ){
            $rank[$score->score] = $i;
            $i++;
        }

        $players = Player::where('leaderboard', '=', $lb)->orderBy('score', 'DESC')->get();
        foreach( $players as $player ){
            $player->rank = $rank[$player->score];
            $player->save();
        }

        return response()->json( $players );
    }


    // public function deletePlayer($id){
    //     $player  = Player::find($id);
    //     $player->delete();

    //     return response()->json('deleted');
    // }

    // public function updatePlayer(Request $request,$id){
    //     $Book  = Book::find($id);
    //     $Book->title = $request->input('title');
    //     $Book->author = $request->input('author');
    //     $Book->isbn = $request->input('isbn');
    //     $Book->save();
    //     return response()->json($Book);
    // }

    //
}
