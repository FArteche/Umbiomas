<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bioma;
use App\Models\Fauna;
use App\Models\Area_Preservacao;
use App\Models\Caracteristica_SE;
use App\Models\Clima;
use App\Models\Flora;
use App\Models\Hidrografia;
use App\Models\Post;
use App\Models\Relevo;
use App\Http\Resources\Api\V1\FaunaResource;
use App\Http\Resources\Api\V1\PostResource;
use App\Http\Resources\Api\V1\Area_PreservacaoResource;
use App\Http\Resources\Api\V1\Caracteristica_SEResource;
use App\Http\Resources\Api\V1\ClimaResource;
use App\Http\Resources\Api\V1\FloraResource;
use App\Http\Resources\Api\V1\HidrografiaResource;
use App\Http\Resources\Api\V1\RelevoResource;

class PublicContentController extends Controller
{
    public function areasPreservacao(Request $request, Bioma $bioma)
    {
        $query = $bioma->area_preservacao()->with('tipoap');
        if ($request->has('search')) {
            $query->where('nome_ap', 'like', '%' . $request->search . '%');
        }
        return Area_PreservacaoResource::collection($query->paginate(20));
    }

    public function showAreaPreservacao(Area_Preservacao $area_preservacao)
    {
        $area_preservacao->load('tipoap');
        return new Area_PreservacaoResource($area_preservacao);
    }

    public function caracteristicasSE(Request $request, Bioma $bioma)
    {
        $query = $bioma->caracteristica_se()->with('tipocse');
        if ($request->has('search')) {
            $query->where('nome_cse', 'like', '%' . $request->search . '%');
        }
        return Caracteristica_SEResource::collection($query->paginate(20));
    }

    public function showCaracteristicaSE(Caracteristica_SE $caracteristica_se)
    {
        $caracteristica_se->load('tipocse');
        return new Caracteristica_SEResource($caracteristica_se);
    }

    public function clima(Request $request, Bioma $bioma)
    {
        $query = $bioma->clima();
        if ($request->has('search')) {
            $query->where('nome_clima', 'like', '%' . $request->search . '%');
        }
        return ClimaResource::collection($query->paginate(20));
    }

    public function showClima(Clima $clima)
    {
        $clima->load('biomas');
        return new ClimaResource($clima);
    }

    public function fauna(Request $request, Bioma $bioma)
    {
        $query = $bioma->fauna();
        if ($request->has('search')) {
            $query->where('nome_fauna', 'like', '%' . $request->search . '%');
        }
        return FaunaResource::collection($query->paginate(20));
    }

    public function showFauna(Fauna $fauna)
    {
        $fauna->load('biomas');
        return new FaunaResource($fauna);
    }
    public function flora(Request $request, Bioma $bioma)
    {
        $query = $bioma->flora();
        if ($request->has('search')) {
            $query->where('nome_flora', 'like', '%' . $request->search . '%');
        }
        return FloraResource::collection($query->paginate(20));
    }

    public function showFlora(Flora $flora)
    {
        $flora->load('biomas');
        return new FloraResource($flora);
    }

    public function hidrografia(Request $request, Bioma $bioma)
    {
        $query = $bioma->hidrografia();
        if ($request->has('search')) {
            $query->where('nome_hidrografia', 'like', '%' . $request->search . '%');
        }
        return HidrografiaResource::collection($query->paginate(20));
    }

    public function showHidrografia(Hidrografia $hidrografia)
    {
        return new HidrografiaResource($hidrografia);
    }

    public function relevo(Request $request, Bioma $bioma)
    {
        $query = $bioma->relevo();
        if ($request->has('search')) {
            $query->where('nome_relevo', 'like', '%' . $request->search . '%');
        }
        return RelevoResource::collection($query->paginate(20));
    }

    public function showRelevo(Relevo $relevo)
    {
        return new RelevoResource($relevo);
    }

    public function posts(Bioma $bioma)
    {
        $posts = $bioma->posts()->with('postador')->where('aprovado_post', true)->latest()->paginate(10);
        return PostResource::collection($posts);
    }

    public function showPost(Post $post)
    {
        return new PostResource($post);
    }
}
