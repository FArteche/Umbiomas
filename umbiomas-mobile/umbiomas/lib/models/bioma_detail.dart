import 'package:latlong2/latlong.dart';

class BiomaDetail {
  final int id;
  final String nome;
  final String? descricao;
  final String? imagemUrl;
  final int? populacao;
  final List<LatLng>? areaGeografica;

  BiomaDetail({
    required this.id,
    required this.nome,
    this.descricao,
    this.imagemUrl,
    this.populacao,
    this.areaGeografica,
  });

  factory BiomaDetail.fromJson(Map<String, dynamic> json) {
    List<LatLng>? coords;
    if (json['area_geografica'] != null && json['area_geografica'] is List) {
      coords = (json['area_geografica'] as List<dynamic>)
          .map((point) {
            if (point is List &&
                point.length >= 2 &&
                point[0] is num &&
                point[1] is num) {
              return LatLng(point[0].toDouble(), point[1].toDouble());
            } else {
              return null;
            }
          })
          .whereType<LatLng>()
          .toList();
    }

    return BiomaDetail(
      id: json['id'] as int? ?? 0,
      nome: json['nome'] as String? ?? 'Nome Indisponível',
      descricao: json['descricao'] as String?,
      imagemUrl: json['imagem_url'] as String?,
      populacao: json['populacao'] as int?,
      areaGeografica: coords,
    );
  }
}
