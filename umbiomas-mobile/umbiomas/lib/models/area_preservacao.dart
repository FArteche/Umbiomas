import 'package:latlong2/latlong.dart';
import 'package:umbiomas/models/tipo_area_preservacao.dart';

class AreaPreservacao {
  final int id;
  final String nome;
  final String? descricao;
  final String? imagemUrl;
  final LatLng? localizacao;
  final TipoAreaPreservacao? tipo;

  AreaPreservacao({
    required this.id,
    required this.nome,
    this.descricao,
    this.imagemUrl,
    this.localizacao,
    this.tipo,
  });

  factory AreaPreservacao.fromJson(Map<String, dynamic> json) {
    LatLng? point;
    if (json['localizacao'] != null && json['localizacao'] is Map) {
      final Map<String, dynamic> coordsMap = json['localizacao'];
      if (coordsMap.containsKey('lat') &&
          coordsMap['lat'] is num &&
          coordsMap.containsKey('lng') &&
          coordsMap['lng'] is num) {
        point = LatLng(
          coordsMap['lat'].toDouble(),
          coordsMap['lng'].toDouble(),
        );
      }
    }

    TipoAreaPreservacao? tipoObj;
    if (json['tipo'] != null && json['tipo'] is Map<String, dynamic>) {
      tipoObj = TipoAreaPreservacao.fromJson(json['tipo']);
    }

    return AreaPreservacao(
      id: json['id'] as int? ?? 0,
      nome: json['nome'] as String? ?? 'Nome indisponível',
      descricao: json['descricao'] as String ?,
      imagemUrl: json['imagem_url'] as String ?,
      localizacao: point,
      tipo: tipoObj
    );
  }
}
