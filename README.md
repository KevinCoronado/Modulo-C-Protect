# 🛡️ Módulo C-Protect

Este proyecto implementa un módulo de ciberseguridad desarrollado en PHP que incluye mecanismos de protección contra accesos no autorizados, bots, y ataques comunes. Además, integra un criptosistema personalizado llamado **Kiwi**, diseñado para el cifrado seguro de información.

## 📌 Funcionalidades principales

---

## 🔒 Bloqueador de IPs por Subred

Este sistema permite el acceso únicamente a direcciones IP dentro de una subred específica. Las demás IPs son bloqueadas automáticamente, reduciendo así el riesgo de accesos externos no autorizados.

> Este mecanismo es útil para entornos privados o redes internas donde se desea limitar el acceso a ciertos rangos IP.

**📸 Ejemplo visual del bloqueador de IPs:**  
<img width="1010" height="445" alt="image" src="https://github.com/user-attachments/assets/8bcaf89c-96e4-4734-ab4f-1cddecb32b91" />



---

## 🤖 Sistema CAPTCHA Antibots

Para evitar interacciones automatizadas, se implementó un sistema CAPTCHA ligero que requiere verificación humana antes de permitir el acceso a ciertos recursos.

> Ideal para formularios de login, registro u otras operaciones sensibles donde se desee evitar ataques de fuerza bruta automatizados.

**📸 Vista del sistema CAPTCHA:**  
<img width="476" height="364" alt="image" src="https://github.com/user-attachments/assets/c1b0009b-63f8-4ab6-b618-a697b3bb5a04" />




---

## 🕒 Control de Sesiones con Tiempo de Vida

El sistema controla las sesiones activas y les asigna una duración limitada. Una vez vencido el tiempo de vida, la sesión se destruye automáticamente, obligando al usuario a iniciar sesión de nuevo.

> Esto incrementa la seguridad en aplicaciones donde el abandono de sesiones abiertas puede comprometer la información del usuario.

**📸 Vista de la gestión de sesiones:**  
<img width="513" height="359" alt="image" src="https://github.com/user-attachments/assets/08cf6c03-353e-44ce-b602-47519e18bea3" />



---

## 🧬 Criptosistema Kiwi 🔐

Se desarrolló un criptosistema personalizado llamado **Kiwi**, el cual combina técnicas avanzadas de cifrado para proteger datos sensibles.

### 🔑 Características:

- **Tipo**: Cifrado híbrido (simétrico + clave pública/privada).
- **Estructura**: Cifrado por bloques.
- **Capas de cifrado**:
  1. **Permutación** de bits
  2. **Rotación** de bloques
  3. **Operación XOR** con clave

 
  **📸 Diagrama del criptosistema:**  
  <img width="524" height="812" alt="image" src="https://github.com/user-attachments/assets/dd4a6e80-3f0c-4160-8cd3-6eb3e377470d" />





  **📸 Diagrama de la creacion de llaves:**  
  <img width="822" height="803" alt="image" src="https://github.com/user-attachments/assets/6dc14ef4-2192-4315-978c-f3bb58b219d0" />




> Este enfoque multi-capa refuerza la resistencia contra ataques de análisis criptográfico.

### 🔐 Tamaño del espacio de claves:

- 2¹²⁸ combinaciones posibles
- Aproximadamente **3.4 × 10³⁸** (340 sextillones)

**📸 Ejemplo visual del criptosistema en acción:**  
<img width="1166" height="500" alt="image" src="https://github.com/user-attachments/assets/d8c55ba7-bacc-420c-b856-eb61d4978255" />

<img width="1209" height="445" alt="image" src="https://github.com/user-attachments/assets/b8f25044-230a-4eee-a905-54c28bf154c4" />



