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
      id: json['id'],
      nome: json['nome'],
      descricao: json['descricao'],
      imagemUrl: json['imagem_url'],
      tipo: tipoObj,
    );
  }
}
