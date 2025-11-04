import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:umbiomas/models/area_preservacao.dart';
import 'package:umbiomas/models/bioma_detail.dart';
import 'package:umbiomas/models/caracteristica_se.dart';
import 'package:umbiomas/models/clima.dart';
import 'package:umbiomas/models/fauna.dart';
import 'package:umbiomas/models/flora.dart';
import 'package:umbiomas/models/hidrografia.dart';
import 'package:umbiomas/models/post.dart';
import 'package:umbiomas/models/quiz_question.dart';
import 'package:umbiomas/models/ranking_entry.dart';
import 'package:umbiomas/models/relevo.dart';
import '../api/api_constants.dart';
import '../models/info_postador.dart';
import '../models/new_post.dart';
import '../models/new_sugestao.dart';
import '../models/bioma.dart';

class ApiService {
  //GET BIOMAS
  Future<List<Bioma>> fetchBiomas() async {
    final response = await http.get(
      Uri.parse('${ApiConstants.baseUrl}/biomas'),
      headers: {'Accept': 'application/json'},
    );

    if (response.statusCode == 200) {
      List<dynamic> body = jsonDecode(response.body)['data'];
      List<Bioma> biomas = body
          .map((dynamic item) => Bioma.fromJson(item))
          .toList();
      return biomas;
    } else {
      print('Erro HTTP: ${response.statusCode}');
      print('Corpo da Resposta: ${response.body}');
      throw Exception(
        'Falha ao carregar os biomas: (Status: ${response.statusCode})',
      );
    }
  }

  //GET DETALHES DO BIOMA
  Future<BiomaDetail> fetchBiomaDetails(int biomaId) async {
    final response = await http.get(
      Uri.parse('${ApiConstants.baseUrl}/biomas/$biomaId'),
      headers: {'Accept': 'application/json'},
    );

    if (response.statusCode == 200) {
      Map<String, dynamic> body = jsonDecode(response.body)['data'];
      return BiomaDetail.fromJson(body);
    } else {
      print('Erro HTTP: ${response.statusCode}');
      print('Corpo da Resposta: ${response.body}');
      throw Exception(
        'Falha ao carregar detalhes do bioma (ID: $biomaId, Status: ${response.statusCode})',
      );
    }
  }

  // Função genérica para buscar listas paginadas
  Future<List<T>> _fetchPaginatedList<T>(
    String endpoint,
    T Function(Map<String, dynamic>) fromJson,
  ) async {
    final response = await http.get(
      Uri.parse(endpoint),
      headers: {'Accept': 'application/json'},
    );

    if (response.statusCode == 200) {
      List<dynamic> body = jsonDecode(response.body)['data'];
      List<T> items = body.map((dynamic item) => fromJson(item)).toList();
      //TODO: Implementar carregamento de próximas páginas se necessário
      return items;
    } else {
      print('Erro HTTP: ${response.statusCode} ao buscar $endpoint');
      print('Corpo da Resposta: ${response.body}');
      throw Exception(
        'Falha ao carregar lista (Status: ${response.statusCode})',
      );
    }
  }

  //GET Fauna de um bioma (Com pesquisa)
  Future<List<Fauna>> fetchFauna(int biomaId, {String? search}) async {
    String url = '${ApiConstants.baseUrl}/biomas/$biomaId/fauna';
    if (search != null && search.isNotEmpty) {
      url += '?search=${Uri.encodeComponent(search)}';
    }
    return _fetchPaginatedList(url, Fauna.fromJson);
  }

  //GET Flora de um bioma (Com pesquisa)

  Future<List<Flora>> fetchFlora(int biomaId, {String? search}) async {
    String url = '${ApiConstants.baseUrl}/biomas/$biomaId/flora';
    if (search != null && search.isNotEmpty) {
      url += '?search=${Uri.encodeComponent(search)}';
    }
    return _fetchPaginatedList<Flora>(url, Flora.fromJson);
  }

  //GET AreaPreservacao de um bioma (Com pesquisa)

  Future<List<AreaPreservacao>> fetchAreaPreservacao(
    int biomaId, {
    String? search,
  }) async {
    String url = '${ApiConstants.baseUrl}/biomas/$biomaId/areas-preservacao';
    if (search != null && search.isNotEmpty) {
      url += '?search=${Uri.encodeComponent(search)}';
    }
    return _fetchPaginatedList<AreaPreservacao>(url, AreaPreservacao.fromJson);
  }

  //GET Relevo de um bioma (Com pesquisa)

  Future<List<Relevo>> fetchRelevo(int biomaId, {String? search}) async {
    String url = '${ApiConstants.baseUrl}/biomas/$biomaId/relevo';
    if (search != null && search.isNotEmpty) {
      url += '?search=${Uri.encodeComponent(search)}';
    }
    return _fetchPaginatedList<Relevo>(url, Relevo.fromJson);
  }

  //GET Hidrografia de um bioma (Com pesquisa)

  Future<List<Hidrografia>> fetchHidrografia(
    int biomaId, {
    String? search,
  }) async {
    String url = '${ApiConstants.baseUrl}/biomas/$biomaId/hidrografia';
    if (search != null && search.isNotEmpty) {
      url += '?search=${Uri.encodeComponent(search)}';
    }
    return _fetchPaginatedList<Hidrografia>(url, Hidrografia.fromJson);
  }

  //GET Clima de um bioma (Com pesquisa)

  Future<List<Clima>> fetchClima(int biomaId, {String? search}) async {
    String url = '${ApiConstants.baseUrl}/biomas/$biomaId/clima';
    if (search != null && search.isNotEmpty) {
      url += '?search=${Uri.encodeComponent(search)}';
    }
    return _fetchPaginatedList<Clima>(url, Clima.fromJson);
  }

  //GET POSTS DO BIOMA
  Future<List<Post>> fetchPostsByBioma(int id) async {
    final response = await http.get(
      Uri.parse('${ApiConstants.baseUrl}/biomas/$id/posts'),
      headers: {'Accept': 'application/json'},
    );

    if (response.statusCode == 200) {
      List<dynamic> body = jsonDecode(response.body)['data'];
      List<Post> posts = body
          .map((dynamic item) => Post.fromJson(item))
          .toList();
      return posts;
    } else {
      print('Erro HTTP: ${response.statusCode}');
      print('Corpo da Resposta: ${response.body}');
      throw Exception(
        'Falha ao carregar os Posts: (Status: ${response.statusCode})',
      );
    }
  }

  //GET CaracteristicaSe de um bioma (Com pesquisa)

  Future<List<CaracteristicaSe>> fetchCaracteristicaSe(
    int biomaId, {
    String? search,
  }) async {
    String url = '${ApiConstants.baseUrl}/biomas/$biomaId/caracteristicas-se';
    if (search != null && search.isNotEmpty) {
      url += '?search=${Uri.encodeComponent(search)}';
    }
    return _fetchPaginatedList<CaracteristicaSe>(
      url,
      CaracteristicaSe.fromJson,
    );
  }

  //GET genérico para detalhes de um item
  Future<T> _fetchItemDetail<T>(
    String endpoint,
    T Function(Map<String, dynamic>) fromJson,
  ) async {
    final response = await http.get(
      Uri.parse(endpoint),
      headers: {'Accept': 'application/json'},
    );
    if (response.statusCode == 200) {
      Map<String, dynamic> body = jsonDecode(response.body);
      if (body.containsKey('data') && body['data'] is Map) {
        body = body['data'];
      }
      return fromJson(body);
    } else {
      print('Erro HTTP: ${response.statusCode} ao buscar $endpoint');
      print('Corpo da Resposta: ${response.body}');
      throw Exception(
        'Falha ao carregar detalhes (Status: ${response.statusCode})',
      );
    }
  }

  Future<Fauna> fetchFaunaDetail(int id) async {
    return _fetchItemDetail<Fauna>(
      '${ApiConstants.baseUrl}/fauna/$id',
      Fauna.fromJson,
    );
  }

  Future<Flora> fetchFloraDetail(int id) async {
    return _fetchItemDetail<Flora>(
      '${ApiConstants.baseUrl}/flora/$id',
      Flora.fromJson,
    );
  }

  Future<Relevo> fetchRelevoDetail(int id) async {
    return _fetchItemDetail<Relevo>(
      '${ApiConstants.baseUrl}/relevo/$id',
      Relevo.fromJson,
    );
  }

  Future<Hidrografia> fetchHidrografiaDetail(int id) async {
    return _fetchItemDetail<Hidrografia>(
      '${ApiConstants.baseUrl}/hidrografia/$id',
      Hidrografia.fromJson,
    );
  }

  Future<Clima> fetchClimaDetail(int id) async {
    return _fetchItemDetail<Clima>(
      '${ApiConstants.baseUrl}/clima/$id',
      Clima.fromJson,
    );
  }

  Future<AreaPreservacao> fetchAreaPreservacaoDetail(int id) async {
    return _fetchItemDetail<AreaPreservacao>(
      '${ApiConstants.baseUrl}/areas-preservacao/$id',
      AreaPreservacao.fromJson,
    );
  }

  Future<CaracteristicaSe> fetchCaracteristicaDetail(int id) async {
    return _fetchItemDetail<CaracteristicaSe>(
      '${ApiConstants.baseUrl}/caracteristicas-se/$id',
      CaracteristicaSe.fromJson,
    );
  }

  //POST NOVO POST
  Future<void> createPost({
    required InfoPostador postador,
    required NewPost post,
    File? midia,
  }) async {
    var uri = Uri.parse('${ApiConstants.baseUrl}/posts');
    var request = http.MultipartRequest('POST', uri)
      ..headers.addAll({'Accept': 'application/json'});

    request.fields['postador[nome]'] = postador.nome;
    request.fields['postador[email]'] = postador.email;
    request.fields['postador[telefone]'] = postador.telefone!;
    request.fields['postador[instituicao]'] = postador.instituicao;
    request.fields['postador[ocupacao]'] = postador.ocupacao!;
    request.fields['post[titulo]'] = post.titulo;
    request.fields['post[texto]'] = post.texto;
    request.fields['post[bioma_id]'] = post.biomaId.toString();

    if (midia != null) {
      request.files.add(
        await http.MultipartFile.fromPath('post[midia]', midia.path),
      );
    }

    final response = await request.send();

    if (response.statusCode != 201) {
      final responseBody = await response.stream.bytesToString();
      print('Erro ao criar post: ${response.statusCode}');
      print('Resposta: $responseBody');
      throw Exception('Falha ao criar o post (Status: ${response.statusCode})');
    }
  }

  // POST NOVA SUGESTAO
  Future<void> createSugestao({
    required InfoPostador postador,
    required NewSugestao sugestao,
  }) async {
    final response = await http.post(
      Uri.parse('${ApiConstants.baseUrl}/sugestoes'),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: jsonEncode({
        'postador': postador.toJson(),
        'sugestao': sugestao.toJson(),
      }),
    );

    if (response.statusCode != 201) {
      print('Erro ao criar sugestão: ${response.statusCode}');
      print('Resposta: ${response.body}');
      throw Exception(
        'Falha ao enviar sugestão (Status: ${response.statusCode})',
      );
    }
  }

  // Função para buscar as perguntas do quiz de um bioma
  Future<List<QuizQuestion>> fetchQuizQuestions(int biomaId) async {
    final response = await http.get(
      Uri.parse('${ApiConstants.baseUrl}/biomas/$biomaId/quiz'),
      headers: {'Accept': 'application/json'},
    );

    if (response.statusCode == 200) {
      List<dynamic> body = jsonDecode(response.body);
      List<QuizQuestion> questions = body
          .map((dynamic item) => QuizQuestion.fromJson(item))
          .toList();
      return questions;
    } else {
      print('Erro HTTP: ${response.statusCode}');
      print('Corpo da Resposta: ${response.body}');
      throw Exception(
        'Falha ao carregar o quiz (Status: ${response.statusCode})',
      );
    }
  }

  // Função para buscar o ranking semanal de um bioma
  Future<List<RankingEntry>> getRanking(int biomaId) async {
    final response = await http.get(
      Uri.parse('${ApiConstants.baseUrl}/biomas/$biomaId/ranking'),
      headers: {'Accept': 'application/json'},
    );

    if (response.statusCode == 200) {
      List<dynamic> body = jsonDecode(response.body);
      List<RankingEntry> ranking = body
          .map((dynamic item) => RankingEntry.fromJson(item))
          .toList();
      return ranking;
    } else {
      print('Erro HTTP: ${response.statusCode} ao buscar ranking');
      throw Exception('Falha ao carregar ranking');
    }
  }

  //Função para enviar a pontuação do quiz
  Future<void> submitQuizScore({
    required int biomaId,
    required int score,
    required InfoPostador postador,
  }) async {
    final response = await http.post(
      Uri.parse('${ApiConstants.baseUrl}/quiz/submit'),
      headers: {
        'Content-Type': 'application/json; charset=UTF-8',
        'Accept': 'application/json',
      },
      body: jsonEncode({
        'bioma_id': biomaId,
        'score': score,
        'postador': postador.toJson(), // Usa o método toJson que já definimos
      }),
    );

    if (response.statusCode != 201) {
      print('Erro ao salvar pontuação: ${response.statusCode}');
      print('Resposta: ${response.body}');
      throw Exception(
        'Falha ao salvar a pontuação (Status: ${response.statusCode})',
      );
    }
  }
}
