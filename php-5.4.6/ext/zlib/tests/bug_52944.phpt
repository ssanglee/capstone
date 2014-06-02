--TEST--
Bug #52944 (segfault with zlib filter and corrupted data)
--SKIPIF--
<?php if (!extension_loaded("zlib")) print "skip"; ?>
<?php
include "func.inc";
if (substr(PHP_OS, 0, 3) == 'WIN' && version_compare(get_zlib_version(), '1.2.7') < 0) {
	die('skip - only for zlib >= 1.2.7 on windows');
}
--INI--
allow_url_fopen=1
--FILE--
<?php
$data =
'U3XuBFLaJfQAWt4cqi8u8ugXxyDcPTZy8VicbJr50gGTEh0dmo+d8O4uBCTuAf3dHbbDYTieluscWXkKlavfKdMkZZRP3GpTApbb'.
'mQONJCgdbpPHat6iGOoq34vIGCLKFuD8qiA4ti5AL7bArvDtd7i+5tvn49j1L3bwroIsk1iPS5leATIwp1iwk+VdPLzu7tsexYBf'.
'giLx7WtQI779GtQIKD1QI4AT1Ihvf0I1Iu1u1Ca+7Vs3TtfqiCXvrm99EuJy/ix5z1VD8atW9sUyvmu/pQn8KU5lZvHUqC5xzgow'.
'0e8m/e5n5fLH2EPhBn4CA3n0p02/E/hVlAgxNIczOk7H7shAHSyUQ7PIwicPE/xNw7Nq4F+aHj2CowlZQKvhr2+fGIhA1QsSG6SD'.
'y3MBWfRsWxpYq08oqfievkq2Du7uwO99DGhG4GQrIODp67QfRFEFnrUQWD1qV2R44JVHoEjwt5c6ASus4MdOAtA+2OZAHLLOA9O6'.
'4kgGY4wOggODnQMWrk6fnTn4s4E/GG/QqEPiOiY+PWvij9MDz+0qM8WlyB6rGiGdVcVbChvQJhcjos7ShfrFxU017nBgsMHx2OON'.
'NV7mx3AovW/veYYnlUfNlF1TNysBvNPrs5V6ClWzREIaxqSGPIK+EoQEeqBvCarbQHOQnolOl/jMrmXPMBWbIDRkzJPVo3kCD3Us'.
'NRXjK+Ad8/fMLPiqY7+CulD4Vc/pga9nIEdhGDsx1qvT4Aw9rpW6rGtv5tqvcnMLWCNgtbu7BZ25GYiGMwiStZFNs0jY+uxVFrcG'.
'rOVt+PaYWLhRRxt3rOCm2E/BUUA75CBa7wmWkSkXFyV7bsA/9NU5TPSC8jU9p/fSqS0u9l44323oNb1h6KfYl1mvAYIzNUX0Csfp'.
'pozkYa12FecgDSsD86KHnATUwz8uzu3jbL5Bkb9UyUtMjL30feyC0oVBYY/DcR8DYdAnbI1FcItMFuAcIkNLx7498TGqFlN49v/K'.
'5TdaEbZPfKhWMwvZw5SKGjMvAGm6xBrEIRtYsmfRcY0NfA5ogzyuzS2nO9sCMcVkMlxTpc03vuJcSkv9T4aZkYktzv5j3FUIf9Eu'.
'EVuPX9ZM2dBAEEEAmEzVXRcbdmMfGoEF0hn+ufCvjZoGXMbSLKGXRkIhYEcJFHzrGphvw7M/YAd1MT/q4b1weBHE7+N+ge1EyDGK'.
'vT/q0GzHs65w1UpMcFyhKRUsLtZfOj1gG3MMrfijvnyV7gJ6DOJTfsQwogzOuESkGzr2vt7AB5ltDDDgs1YBLCP2Hs4ep/INGvDn'.
'0gS4x7TeREJvQoEvnXoNF2AxzeJZadBG9nsfE1DhTWy/BU0CvZ/t/8VxK1No7y8OsiarJz7+Z4eP7zN0XqDFE2fBdgcLzaFdGau4'.
'eCY+NT0bWZiQ9RJ8xXipdAO0oplw23O6CXo1DvAcC7C0VnHjT9+dnveSDURCDL+J058ivgw1MKpyUank1fTE7eD+MYNOtKepW3EM'.
'5BaeogscRezzQwX74AjxOVQW7QYa4BPofdJVOrFAYE2dq42rbINe19qxXjuXQquNl2liaVckfFge4ywTvwxcfNuyttEveIsC5Efh'.
't/0A5I1okwDIHgrUs3fN2x3Q79uewcOW4/dgcJII2THNt84OUqH5dlnqMzEPzLrjLQi4S+MtVgp6vWcf+ZBE33o8admzR8jNW06P'.
'QldnMQigV9BkjL7s2W0fRg+kbGLKAf78yTVnjHqLJv5Qjv0IeEDy4yPGq0JBW+BDvsVZShTCaCWReUxyexvGUy8LRxw72zipLkfM'.
'a5oI2gU7/g1j8VDFlbFspQbEOJs7RdSJJDjP95E1IHKcjuHLG4xcDeh/dWXyLkXf/JFL2QJcW2nE5NXi4hT+b7e6jjOGiqHNMbWT'.
'sLVBvw1MQLgf8dt69bepfRWCHfyDIx4Z+RYGUv6AqwxbGGD5A8YzzGY9+71nbKlzi0glZwx/ABx/NvCnUYMEyJXuvXns4PsG/jQ6'.
'9kcfPq8j/DqmrZ9xXXoYSLidm1i1f/LA7BI807Pf4oZPYI19F9WRQRAtZJMeRRzCn8DnwMM9PzepeCNEb883OvT9HP0ovLO8UkY9'.
'/oSSaM+n4dt20Kigx0lBgiPHgQFn4nAVc8ufSMdg4i0Z5mg0oDjD7s0saDFcEhehwEJntB2onT2hGTAXAx8MKgAVNU21E8wQNYXQ'.
'NFf40yNVQga+Z0+xrAmk7oMUQWOfM/2ZTX758olZiaMm33pQ/X1BtvOrMAnHeJiBSheFXMKD94DNU2mkmsvE3AGrJtVcB2n/4inK'.
'jwAZCUviQzNQgOMJojl7IF8e6YyJidrAa1HrParr/hwJifakm3TB5m8GqSGxuFhz2Nv4I4tpcyMhr4FeaN2ikWvSsZuGlgZCVWHF'.
'Np2AKxTgEbXkY+6FyRivfDWrEnEbI0h5C9WhRdKUIws1Ah6PXb/LjqrO8bUMac6wX7iXoKV/qlgtU/vKMP8GXcQaGMxdF4PtMdNP'.
'ZfKg8U56sg92RdJk2/hHYYCN5zp4Y3bwxvRIDt4rezRJujhIQWXMspk1tCIWF4Fj37holt/deS/w2ZSTfD2cxMJZPbDZ0OYnSf04'.
'AG019g+HdEw8gKmvDnh0/LSRPjWAIn4zfc2aeSUXcBYeU1jd2I1B897dKS8OKHsMHdJLqeNoVE7kY6f05tQBMfvYtSMfCsHh2TKu'.
'LJozmKY8Pt2g/m3wGcJKGzaKCYCjQaYqLY9ja5xckLecwnjndoKrMLh2ChaskC6FQQLdYmK3k6T6hmzudB5gliE9wbMKq0ZO2+Kd'.
'frgGaU2bFYOwh4YbGc/Zhj9Itfsuumm46+8WuYgSemdNDMUOrLF9bIiF1SvIcfVibPsEfwXwEgRSrs4IkLhpCoDTFzjumlOAIgv7'.
'dHqWGtnCI+BW4UFq1KaFKnGAPM8tcjzFDns13W1tFBMMjlEFXCANwEPGsKQoHiwupo+2BNgoJzXw8Jci0Ug780lYtzhDwyI4bF6x'.
'tqUz//T3J/sNHcfVGwcG5Bv26+FhQ7/TQV2+UfYjXUmH+PYKvF9nYOAfXIFs05MF0GZuD+I1bxzCPYYAjX94gfYEikCDHljmHIQW'.
'UdBAG97qgZKGn3X8eYo/z/DnOf58iz/fnZmpI6Hv5tHsjoPB/VhMZvm0zJxnI7sKbVamF/wDJ7XXkHRLpV/PHnqUZUHNI1FjPSox'.
'M2fsNKtw7xDv3pBTh3Jpx8SUjDoe7Ssr/t9s7tgDz8hKkEz5kxsXB26mjTbLQ5gd0ryBQfK6DbLuACweipYkhxgdULB45bjEIYlj'.
'hFzVsQOI9LI/eo5Cvzx90cFAgZLOlXo0DtD6ybmilDPD+Gr6DgT5PLw4dFw+wKZQgkwvoxcfLGV8/5ybY+ZeR4R9OdUvJqZS+MKc'.
's5i2khnoq5qlU1GEomn7cvac2y5zlAvJ5ekoBXEmmg4vFCRqJWfSDU8FLZagAgvcApwcX4zNnW+3KWE2YAQKUg1bPxdm05UZpCod'.
'QOJfTouMHbo2uDhDcozKx1ymCZKK+RG2g1QRLvx2xHWCOiqI77EHF3INCaEsyzUz/VZsDo99btQVL3dOHTSHKdSbBiP8BunIxD/Q'.
'kVOlT56ZzWmO6pBwBb6UZL5nVh1s0o0rPqys8GkNel/5BI5a7+5OBVgHLswDjCWAKA3QjzMQmuDJdZ4xFcc9XYlZf0GhqxmZKhXj'.
'oLpb2QyUXsI4reNzqEBAwoCl1JXT28ixWewzk2fHsDUVeVTikTHNoQn+mMMZ1hXzRpybchWrwo89E5V7YBNqMbVKXjKa6zlzsufk'.
'3oVshy4QS3Y9MPPSWuvCHpWGY1C0GsnGl0s+DtMkVYZBwZokYHiw02MjvySnMDkpMz/PzY/0ifyikqkgDvhBfOcL9CYY5bY/jvvi'.
'0e1jIum7gPac24Oohaeixwlae4FNHGYihuxDmm5vHR6cHB3une9vHv+I6Kpgjt/uvj65F2Jzj7/nJomR+3jKD6fL8tO4vMaEMSSt'.
'qrMG7I40BA458LMgpdHs7Nht3v3l2z5ZEqYieUvZsMg270hz7W51oW03NT86wygOKgqXRQeupQr6efBYaiBLDapLDYqlHoHOLpfY'.
'qSwxB0tklaW15xDWlV1D20regqPt5Dtm5Dke7kiQcFviiCUS7AXYS7cA2w+BHXaH7agAmLjOQgbZqYZUqpmk1dxKpxmK9WQGSt0H'.
'tjq2g344KEC+ySAZGy7LRpNxAezay+C2g3Hgj2kvUAFqoja5MwdSacnEzeM8wUWYAs5xJc4CpIJznOLcA4HSfxO2K+iz7YrmdOaB'.
'KRi38xiPg/gqiPcL00gA5qRdfRQMonEwH7CeQ1iCXiiAr9E5dNU8uy2bgflDPygWVwCEMo/p9PojsEkKROm6WR8f8ynS1cxwojAD'.
'jRQ2cAtQu3n2J8DNod+NioAjtzyoUCoWbckOnmzmqVBbfJpZGTAoAO62yjDtAsw+nXxWhusU4A4OyzDdAswxnY5WhgsLcCdBXFFi'.
'zwOBkGtnVf0vvIyHN30/mgzHlVNpbyXQT7yZsAJIHB+AgBetQjGvMKaPji3BZ4IZFGF+FFXpFz+8UVjqSMR0HIrT5ApW8FTg2PQr'.
'WzH1ZIgLNqVkSKexLqj0RCSMcioojOCFcTzVeEOD2wkEAs3RijgN/f3mSv15vfb06fOVNfCAFfDC1BXYlzONN8hBk/Dy861WFgiz'.
'FTu4UpY7BrK5NYLExKnrzT8sbLXEUduODm2ntdo0ydwaoRviC0h6wcXqqjsHP0XD4LDdBhLTgfxi/+BjB6wzgabNaPCkCblpNb/L'.
'TsD1Ujg2IA2xB/Gxo97KwLDXeJxC7rDERTxU6g8L+fMa9UVcRTdKhzZulFIaImUU3gR9SjGZSNdxCO3VX4SDjoYrmEvixGc8xnIM'.
'OmQV/myETn396fPaYsepLd44a/oy1HIrhuroi7hsL1bTAZsMLaI1/ewLhyylRig7BACCp2sA/vMR4VrSvChuAeMt1Za061Bf1lt4'.
'xn19SesG8IItxrfVlzrWHSh57Cyl9ZYnVcd2iLVONibfrj99Wlsc1RaHSwU+gazbGSuF2ymnhHhiG/FKmmiGx8vO0qJfxxPt+bm1'.
'9FtJ/ocFaPR1oWuXFrtLy7l+xZJOHKiCJKfYO/AteCBvnSpiZgB/WDCMcNcJT9IjZZdWl0xgMgwBMRDtSe5w9nDXNBsiBwcvCDYP'.
'Tx474dsSLJOgvSS7tqqWZkqqOIN7y3QXDAefl3TZ33pN14gWjl7XNaYBPa6+pPPxxTWEssfwnjy3NTVS+fQNEPbR7aPVJ397sLm/'.
'g+79uzgYgL6xewnen4LX8y39ccRp50nXBfqdAxmXTDx3lm/aePRodRVd2+NBkr6TPIvpvhdHWyIl8GyJvmU4z9n6A1TsJSriFYEe'.
'JV1QzJTyIRzKq0i5gEczU+JhJLJq8hrcaoz0NUMploYeyf80BMphPoc+HITjuQj/wBcYprUYdUHmnUOX4iWyg9F4KgjyCLjiG0Mn'.
'lAwjIlZNnI42sFtGfRc4YPX072or35+tdiy8GEEex//Y0epreM/K43uRCCbkqs2rVu56xQ4OHfUi5KUYJWnzXgx4g5+x9Pk///rv'.
'Pv+3z//l8z/8+u9+/ftf/8Pnf9A+/wsk/QWS/vHzP//695//n8//7dd//+t/+PXvNUj6LwD7f37+i4apn/9vzPT5L3iJKfSxpNGj'.
'XIAtd3OJwHGAK3Z0h6mat9RfeB+KobfChDSJbvHtsxlwG1p+jqd6S9glunATWm8pkAyOCu2H48MDQ1/FbJgLhsdIt7ja8N9t+vRo'.
'KRkkshqNuqUpX9ROW2rIKudSRVdaSq5eAmOkgCketpYaWk40p19nVnbdQnZHKh63mnGGXqKnnhvQFQRlvtnMk1VC434eKMBGc0PS'.
'4q/nv3sZMC0vz0PiKhNZoeiCbsh4JJuN19AMEj4nNt/gL6ov1U6prag/ixClmCIeXVRaf+G91JdFzZb1F6veS9ytlGsBISD2RE5C'.
'ZquEqJACxfboSg+WPksKkUGR0uhRlYrEC0QkqMw+E+RWeG0mcK+uziGlvHj3OBoEJ9AF+THMglcIXxvUwygGnXjuTabn3ni+lhi5'.
'U1x4ovt++cphHs5hykdYxjt3ihJfliQ0Efym/5dKiW8TSs7duSWibvv5o1JglBm5go8kknDYRjTAKrdLYPbCmP35I85OLq/VQMD3'.
'g/aYk/BpNje/2vklGSmyfZNdt+NFrem8upMeqqrfEoxpUEHTJbpiZskDBrhYMudUSOUkZctDnrj4T8MfSIHfNCQ5r9Yjr0dVo2nw'.
'aOTAe0pPpJS2oq3Xak0BgXQCwkMbmE9NNgQNc3XNXFl7/gzhkHuQBMIkSOnPxhHK3cwa4jSQt9oSIYLeKKEmvixbGmwEqV0Lv1mn'.
'Uk2ZFuUKZR06D28GMVNIV7BfwuRdOCTqzUPDHVVZh6wP77dfcoBzjQ++SwrZiyuFOKX4wtubgeJgHNpBu43n2OijST8BZ1HHy3HH'.
'4ComjXVtZmnPcMsFtvkR3oZId/6xAau939V2KG+i1e1v7bX5NyF/r22+P3l7eHRsj28gUfg2fMPuJOSQUjzQ/OFrkQ34Wdnb3do5'.
'ON5BZJxDXpZswE/ua3p9cnaJoigc+C2xszt+V9/vrorGrOavKWTyJHd3hjqB0JLpzq04d6mhExF0K3GvguzyhY7V5SgRHCptvETn'.
'RVfefNWmEyzaRve0ffbYceiGQZy5wuUoPfBtvHfB7QQ2eJUAYXUwQjYZT/vBKb5TBIEFuhOg/roCccBwCfPKNqksEAA4ZZiV1bY6'.
'vMbtOPo46uBh+3iActsOE0NvAJO2giEGSOPI0Rs6cm168HVnZoEJ98pNgn44LNaftmRa7WZyHdK5TxhYcesDrI7rSQ3cJchXXlHa'.
'AAqCojHZfqZ+8KLxOBrgh7pIlpemhg7iXO2mNzXIguqyIBQWeqOdLwmYaQzjC5PzJRG7Y3qxoDYdwgkFkeQSjb+9abStaSMEmvKK'.
'74cY9XCsUJbo2hYLXzBKkaL2JFwRbLdyzTkwVFyqnxR4RieROrdUZKNtw8gK4g8kOcmOtrjR8stbFrj8SW+D7YktIa4Qb3SMLJZo'.
'LL1ohVcg81w8PauiOhrxp6O3o+F4Be8obNRrtb9peq5/0aGNXQ0KEeKaNtlhbuA+lObAjTvhsFFrjsCUAwe9UdNfvliF0tBplkeL'.
'yxbyUXZUw1GUhLTvzHRwKyNYSL6OgdSkBeTHhg42Nd16rM/weLv5HzkWWR6ETCXQEibNoiQH7oExwmOhdqEWoVXHTUW4W5Y2ic34'.
'YiqRi/inKltXZOvKbMW6lhpmQQ0aoYUYG13rEx2NIKE+rdDECHRRqqDmN48Q1RhRDdrKJWcbMHooT9C0/n35UXrSH0LgwHa6Z6dN'.
'EoXWnETDMxkAgx/lQNfp3t3dzujODxiekCpBLnD9fjIMxw7Jr/fwZPSI3JgIY/tlDbLjYfvi/Ul7mZ4wfFu9AcodhgMYgeQ8NJSt'.
'lKFFRbAUlftaL4DHJIy+cdEwehu9BolR5tFODlJsrAU4vn9dmmUYBUntKcTpXeJueXyInBabseI43Ei4zjS4dDx2i2b1RFEjKIpv'.
'ANfxCKcR0gNN+Rkd4cdy2byNMBiYXaQ0caMrXClHJjW66EmlrzM+2xXIfzNGN+F2ZmU2rRBxP4XB9UZVIrroeNcXyJjWMdbc4Bsc'.
'kBYNPvtzEiOH0EfeNUfFY2VTf45TuC1cWfyseoBp+ox3c/8b1DZfnaoKK+2RtZVKmjadD9Tt04PTGPRzxmmLi5iyuBins6D6fvRJ'.
'py1/uVRxKaP4wGj6lNWI7QGtPqzSlO5qCFxkPC4lLi4+LogrRMISCz4afVuKlceptAVEWXImhAFVih4lzh0InzvWyHekLlcR5+0l'.
'HsOAheABymIw4olaVsfKb18UtGmpHqUcEeoIqAQ41cWg0M8wnutBmBHrgSo4ayQ6l/o+hbiPXyVQNdeiYKVrN0aj/pS5DnQhMShd'.
'+DTDACDlMicgjDyqH22LxUX8BSN2iJfG+GC3OQ6fTbmBHxp8AgcKcAw5CZy20FPVeR/n8hqh3ZrENOuwkT028JRxs9mFkda+Qc9w'.
'o9YQvdN1nHTn/0a3QQDJKAhayWn37O5OebfPxeATyh3cALffR0MB+KkF+uV1qg3QKOOamuVva/xtrerbOn+DP0L2nqLVB7zVtXpn'.
'M6jMMBUV56g8G5SET9Y5Gqv8jk/W+bkQkJTEz9a57HVOlW/WudLR/ElJsAQm5auSYLFCVXUhaELlMJTU8zjtnG2oL0Q/Zp/bQTDu'.
'Rq1GxxL3GjfaqEattAO7liQ2GKEmqSdQxkiBwpbhlBGBbkBf9TXPcfJ4B2PVSPrR9d0wigdu/67tJmNz1bTH4KbkcpuZoUDCleg/'.
'ZwjQUMwpT2q0Cu1nyC12N9BlsagT/82ahKX/Tk0i14maJNjwv1+jisMq9zUNH1RTQQR4UdQP3KFeJIng/d+JKtLnRLqkQzE3ckK0'.
'IqW9mQ0XW7X6VPSnt4CnAb4pZT0Tmj8d57hpzlIH919ZGKMql6cqCixSlRjzijSkhmw/VjtgcbFtflFdBGOV6qKUTapnZg2ieNRV'.
'ZwG6oKx7VTLqATp3BS0b4AoQhjPAzq54oa15NqIKzOEhS3gDOd+FbXO24qAZbdPq8tWBZIaf6nSLwAivq/sbfAALIDM+enimCgXy'.
'SzPrwiTnwjklI+k1usjQS9ZF3rOA5xR/5v9uoaEFZbDr+4rMoXzaHthK+ZQjtJbySSfRSCb44i/48jiTwslK/clcYMU7DkZ4jFfm'.
'5fBskI0WW+A42Ch8jsdOAKlBPxjglRfwNGw5nkF/zRl/EBNReChY3PEMffmU71Nxb4z0YpXUhoSsYB8+YQwgIFZEMSRflrMXtDOt'.
'tWfPTAv+fjG+eoavruKr/0Z8axm+NRXfWg6f3Jts6eayburY3amN5hnisBg6v7IDNkheCNMldJjK9rrjrGfBd2QOOqtA1F+MX6BO'.
'p7j2fFu31mcmvFpflPSLuQqGTYB7fCXi07SxbUkYJWWtlLJOKWeVtVk2Nhq/2Pxobpi//E2uFl//dW51eWhhhc0na/azZ1Yuda0y'.
'dV2kyqr/0Th1V9qbK6+JQmsz86H3B0n3vES65yXSPTcryzfnvzxQ7HJ12cvVFVgu1gI60P3FqFma+H8FyTXXVubm0mvDT1uQHA4A'.
'MH9D9Fl2oA0IC+mSdJqt6LaDN5hP4q3jY/pAYwDcRfAI8Y9SiI4ewRCcEjoHoovCrTVFm4EP1Ws7JcE545N7uk5XzC4dQO7sABFU'.
'lhzbd+teTtzGaQ2HK/47s9xPkzhonK49VdK8IOxQGrzjvzWQQV4fzWLICf/Dt0nAL5whjq6HjdP682fW0zX4/5nlT91hrpyWG19k'.
'uerr33OShIOELLETB1PEBkn8L00OGLhGlcC0i657EQLsdwD33Tp8+ZbT8Y6j4RiaioiV8iK8r1Ug+u4ZwltPRZYIeoCaDVWuP01L'.
'iGIfzExA9GzdegYNqj3l9DhoSewCMnH7A/AiTtfWoSIAWl9b4w9XIVgdY4B++h1dvFBHPeR3k9Dl0gQVO1G/xQlr9WeINGvw2nf4'.
'Dpo27ESN02+fUZMgRTSfem+9htU+s/qoF5nU9W/XAddz/CbSmd5ra0+znqF0UVT9KXxY/w4QPc0+QF9AnS3xT6SPwuGFoNV3a1b9'.
'+3WRPg0wSlk0A/+tEaZBILkBapJ2jtL4gRtHSDxqKgIN3aupYJa1784s6jj+LKiR66/nhFip1Pdr0FVQqdEkHvUDiZdQpd2RJVFn'.
'cm0ATRL2r4IYAL5fs8S/MwuG2DhQ2oWVLjYW8irjOA/M07VJOOzYPTDmhigOxDu9NtMJOplu3baCdkOHl+BwMv7TBLf/E2huWQjs'.
'0oKRSZlPU+yA5EwBnFmIcHeI+O5D1APFv+qE5pPucpvziErcl2klzWV0V9ZMmXN3eF9eEISUaXXNfFHPyl9de9KlwlPckGIYKytd'.
'gX2lrhSwNfFC/8vak2vRl+RDwboaQnGUt55v1nwE97ZLbRk3rLvirHEJKuGAavH4S9tV7Kv7c64Um/aku1Iv9dkcHA80rqLj0vY9'.
'ybPGnybh8CtaWGjjw3kLTSz34HwkDzbynl4s9eRxcUG33B1kg/tRAoWGT9gif7cLhZvLPaXRDyESeGDwl/Go7X64QtiitE4CzRPA'.
'mR96Ozej6B48QH/woTbaDVGvUXRtgEytYa9it5hK074AVQiolnuAzFhR0K0APqxYsW/nIkQPj3y7dNmNU7LmQymz+QxQbIpoiMoL'.
'xfqh5MpxxFYY+w8NUO7Ky3hs1FfkMFDJjxLoATSSHySSdDgUBNk8NNVEULhDYO6mNVOpkC+bR0e+m3bwZPu8DMWFzoE8Sr7n1O1v'.
'a/Vn3zX5Op9ak6fqB7SMXOpEI1x1+qbj1JWeHPC5/3g6e/9JzV6nzn5BVXM9vEQEJy4G8hDG1afZeje+GqK73+2a/ICK1RisdtNF'.
'W2hZkSPCFaiBmQ1FI3zSX+mB6sqQrV7kmf9/fDrkqIA8Hz5IgeVBfsD+KxABGNcBvptDBgPo8KRuPzN/N2JgTdSRUrOfPflrGGQe'.
'cb8QBXT0M5XKr9CTKwz0i3SoAw3TnUoYxSHILStxQcq4hyoOisNbJ7orocrFfy12kk89VteyhOWyYP9txQhR1suLsguUU10qDyjo'.
'GMAMa89MUzZO6YKLnI6vAMeaqiL+FTjp/v3aeiW11CUFKQ8y/krXqhGwSt/5GKWgNl8Y9dU1+9tnpmoHfWs/e772DM0SREe8TAxv'.
'rM2FxZZi8wQANK+GD4Xs6fc5CNbstRyG79cVHPOyPC/k+e6pyIUhdxkX3EuM7gvUWUXPyFZ7BnM8WRNUpoGS9vXcboEMK6GapScy'.
'4qK0wQGSvHltdbULPjH5xQ18z0Jb6GQ/uRyQAuU2dKpT+5eTYBIUA2MCx+UVdKvlqJPpdMEzzomXptejkeuH46l+JoRmVgURxGgE'.
'lmeL1VFaF7+7E+uGTT52PftKE+zw+Y9t+O/773UR6RNwAFaxbDwzKC3LvcKCWnhKkQjO4ly3hTY0+Cxmq4Cs4c+4Om3ntvipQ8v6'.
'YMeJtcHbti0a7dRmQRpJ0bZuiaR8Zkq2Auylq/kWd34ja7Bwyv0IN3+Pi2uNSpGBCESeZU0W8ajcagFNdKV7JPhCR3uQhIG4Y5qW'.
'EZSNLKE3wQ2c7bCPgZakYbw0MsC8zZ7nLSHarYB5SIZOFBh1XgjzOw5//v9XKLNoVJpjO8DdHkkDXx7JLvOhv+xeIsKe54xcER3+'.
'deO2JcetGDLlUdi6dxS2lVFIIel3d8/Sc1zSwJTscXWt4VZEmKyuNUWQshwqKyszuu4oF6eMq2Q0pKXwsGq4hCcGbisdUrfie6MO'.
'8tkqDhuz2XbaK2tpdJcPhpv/ot30Mfa6AkmtEsmXFjbLN+xL8auhVS25m+Brh5oMlv29G1WI+/raOrUEL+rtGz3fzkwyYHcqb6qQ'.
'ONp5c76/c8w3/eI6He2zEKl4uK++2e9r7TDotxItBhxxGLR0BWQNQN65SXIdxQDRioZLY43C4FSgdQTqo77VXJyRJqmQ8LEcGki+'.
'QaJCPwXovagTDrUw0cLhldsPc0U+g+87AzfsF77/YeH1zs52RXNkclV7wpjbk8Ksqdiv42jYYdx/WHh3dPh6d2+nogDlC5UxlyAq'.
'IBb0+uSd1pdNpcIsbV2ju3i1QQj8MxkUs61XZrO1owADcP0xSF7KL2v9anP7/Hhn82jrraN/jCaa72KNwIJuaa5GO2w0jtzVrsNx'.
'F2Q5COWpNnJjdwDaME7sF178Ev+9A2WXaC9cjY4HXFrlg71xG+rSSyDqi1X3paWNI4GaqNwPRDXev9s7hHq8PjzaP9/df+Poq8lq'.
'OOisnuPdyKvBcJV1pd0J25xh5/z4ZPPk/fGrzaPz7Z3Xm+/3Tk52fj7hfX6OtnQc9ANqazvqY1C9top7u9Vcx5s/7ZxneSjXm2Cs'.
'4emFVbAnh4d7J7vvOIuApRZQjqSY5Wjn9VER/VHQBhp1IUMyroIvFiHhZTHlXFCx3YM3spxH1HL3Co1X2y7CnhyebO4hmxwLeAA+'.
'icau6IiGxhk2f9j8+fzD5m5a8ew/yLAVDYdAWChBgT7eOdiuhD4G9YqcQ3szZY32j9+c7xwdaVpllp04jmIt8v0JDLzHWY7jo5/O'.
'63MKweN/xIWFZFfEgR91huEneAH6jUCWBoIY2OeHP84p+jWRGa3UlpZM6E709qTfnyq1qM4rCNMBtTvpk+pNHucKXKvOsykHwf2F'.
'YtPXKhGcgJgEBu9HuDqkBRnpgHYamAGYiqKUC2lF13SYNJq3eezr1dhxSasNpL12k+EvIBSkCaz2y+bJyRyKgP0KWghjo/OFPeW9'.
'uI8eKZ0HYmoydKn1odcPNKV+rw/3tneOKvuLhnaSgR4cahI3IT+Ism8fd45z3z4GSa6L1ufzBPfOkpA7b452t2G04mEU5ziacuBH'.
'Ad5BwvRm9AT+ZufkfG/34McidilvEokcgc7fH+1V1gXSGSdBvT3Z36uConRAmiiwIFff71dSEKzKKJ4M0goIWXrOcuLdztH5u803'.
'Owxer2Ut2t59t4d0LQ3GLvMic9xtbaataLf1mRa1tdu12VIZwfnJuz0FQf40AC314VGApJfg2OPoPW6v4dAL3qzOx5PUzeUlTewT'.
'hiFQKn+WVeCE5Ofbww/nr48O9/Mt0NpxNGgsVQGfHKrNHYf9fhnu/at9VXziWEDzTIHb2X938rFIP+JYaqoC+WoHOm+nAAqQeJKS'.
'Arb5+gT6CqAeKTDY6JpKdLALzk92T1SmJcDP/8fnv3z+p8///Ot/0j7/4+f/S/v8v37+y6//y+d/+PxPGnz63z//Z+3zvwDEv3z+'.
'r5//UUW3t31UwofoOPs/ahneYq79j/l8kGt/Who3W4d77/cPzunglxyZYJCVwd4d7f60ebKj0CgOr1x/WoY83v1zHuExKIsy2HaG'.
'TYzAEcpP7KI50Gsq9HYlWElmoIipaMzO0e7htiqNp6MKsP0dcL+3c3wx1TjevaLZOSGAbDnAY2+q6HNSpE9VU7YO3x+cHH1UlSCg'.
'i6e/udG7B1uHWVcD2O4QdE4F4Kv3H4/zFXQrOWd7r8Dp231VBh1+OEC7syjEtoWirADNCWcA3UutRaEXjk9guJYE7RHPA1VVEI9K'.
'rSg7qOo/suXUVo/B4kiq6Pj6MFc+nog5D1/90SOqIc45zS20XmOwTW+S3Ae1RlBvaQ5hPtQ6QW0Jc6I/1eKHSn+uVlLzprQnvwy+'.
'uXWye3igcjgf4FQCPNpXB3eKujy0918dwuPh+3evPqqKO44mI6hGCfTVx+1NhTUBtOVOkwqwDzs7P6pdeR0EF1Vw+8Aeb48zuEE0'.
'HHcF4NbbzaMTAVnidDQupcVXAV+SL6T3QKmGUnKo0PeNtyJcJmYknHYV9Seyu/KVBlbND09w2LMhX0KdQqeo54GTt5PCp67OPPD1'.
'2naefOs1Les5FbK+XyA09UgFgY929nNwozi4CqMJOO7VGZ4XEXfdfntlCl50GXbtYwF2TUNAWV0m7u7xu73Nj+cgy/ePC/0M4nyg'.
'GM7bO3sFES37I8ABKizJzVcABuLq9S546WoW5LY40KbRBFwY8XDtDsfo7bcIA3ohibCLN6rQCcH5RSjFpLqWpD7+XLRgO23tnMvZ'.
'BcR9H+IJq3fiESmZWBbnilDlCKPe2X5QJA==';
$fp = fopen('data://text/plain;base64,' . $data, 'r');
stream_filter_append($fp, 'zlib.inflate', STREAM_FILTER_READ);
var_dump(fread($fp,1));
var_dump(fread($fp,1));
fclose($fp);
echo "Done.\n";
--EXPECT--
string(0) ""
string(0) ""
Done.
