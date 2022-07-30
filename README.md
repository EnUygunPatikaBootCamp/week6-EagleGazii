## Lazy Loading ve Eager Loading arasındaki farkları yazınız.


- Lazy Loading (Tembel yükleme), kaynakların veya nesnelerin yüklenmesini veya başlatılmasını, fiilen gerçekleşene kadar geciktirme uygulamasıdır, 
performansı artırmak ve sistem kaynaklarından tasarruf etmek için gereklidir. Örneğin, bir web sayfasında, kullanıcının
görmek için aşağı kaydırmanız gerekir, bir yer tutucu görüntüleyebilir ve tam resmi yalnızca kullanıcı yerine ulaştığında tembel olarak yükleyebilirsiniz.

- İlk yükleme süresini azaltır – Bir web sayfasının geç yüklenmesi, sayfa ağırlığını azaltarak daha hızlı sayfa yükleme süresi sağlar.
- Bant genişliği koruması – Geç yükleme, içeriği yalnızca istendiğinde kullanıcılara sunarak bant genişliğini korur.
- Sistem kaynaklarının korunması – Tembel yükleme, hem sunucu hem de istemci kaynaklarını korur, çünkü yalnızca bazı görüntülerin, JavaScript'in ve diğer kodların gerçekten oluşturulması veya yürütülmesi gerekir.

![Lazy loading and Eager Loading!](https://www.imperva.com/learn/wp-content/uploads/sites/13/2019/01/Lazy-Loading-2.jpg.webp)

- Eager Loading (istekli yükleme), kod yürütülür yürütülmez bir kaynağı başlatır veya yükler. İstekli yükleme, 
bir kaynak tarafından başvurulan ilgili varlıkların önceden yüklenmesini de içerir. Örneğin, include ifadesine 
sahip bir PHP betiği, istekli yükleme gerçekleştirir; yürütülür yürütülmez, istekli yükleme, dahil edilen kaynakları çeker ve yükler.
İstekli yükleme, kaynakları arka planda yüklemek için bir fırsat veya ihtiyaç olduğunda faydalıdır. 
Örneğin, bazı web siteleri bir "yükleniyor" ekranı görüntüler ve web uygulamasının çalışması için gereken tüm kaynakları hevesle yükler.



