import 'package:umbiomas/models/tipo_cse.dart';

class CaracteristicaSe {
  final int id;
  final String nome;
  final String? descricao;
  final String? imagemUrl;
  final TipoCse? tipo;

  CaracteristicaSe({
    required this.id,
    required this.nome,
    this.descricao,
    this.imagemUrl,
    this.tipo,
  });

  factory CaracteristicaSe.fromJson(Map<String, dynamic> json) {
    TipoCse? tipoObj;
    if (json['tipo'] != null && json['tipo'] is Map<String, dynamic>) {
      tipoObj = TipoCse.fromJson(json['tipo']);
    }

    return CaracteristicaSe(
      id: json['id'] as int? ?? 0,
      nome: json['nome'] as String? ?? 'Nome indisponível',
      descricao: json['descricao'] as String?,
      imagemUrl: json['imagem_url'] as String?,
      tipo: tipoObj,
    );
  }
}
