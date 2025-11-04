import 'package:flutter/material.dart';

class NavButton extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final Color color;
  final VoidCallback onPressed;
  final bool iconOnRight;

  const NavButton({
    Key? key,
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.color,
    required this.onPressed,
    this.iconOnRight = false, 
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    
    final iconWidget = Icon(icon, color: Colors.white, size: 28);
    final textWidget = Expanded(
      child: Column(
        crossAxisAlignment: iconOnRight ? CrossAxisAlignment.start : CrossAxisAlignment.start,
        children: [
          Text(
            title,
            style: TextStyle(
              color: Colors.white,
              fontWeight: FontWeight.bold,
              fontSize: 18,
            ),
          ),
          Text(
            subtitle,
            style: TextStyle(
              color: Colors.white.withOpacity(0.9),
              fontSize: 14,
            ),
          ),
        ],
      ),
    );

    return Container(
      decoration: BoxDecoration(
        color: color,
        borderRadius: BorderRadius.circular(16.0),
        boxShadow: [
          BoxShadow(
            color: color.withOpacity(0.3),
            spreadRadius: 2,
            blurRadius: 10,
            offset: Offset(0, 5),
          ),
        ],
      ),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          onTap: onPressed, // Usa a propriedade passada
          borderRadius: BorderRadius.circular(16.0),
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 24.0),
            child: Row(
              children: [
                if (!iconOnRight) iconWidget,
                if (!iconOnRight) SizedBox(width: 16),
                textWidget,
                if (iconOnRight) SizedBox(width: 16),
                if (iconOnRight) iconWidget,
              ],
            ),
          ),
        ),
      ),
    );
  }
}