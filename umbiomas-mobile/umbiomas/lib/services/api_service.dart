import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:umbiomas/models/bioma_detail.dart';
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
}
