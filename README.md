# webdoumi
기본형 홈페이지 

# 부탁의 말씀
- 본 소스는 완전 무료이지만, 소스를 통해 생성된 사이트 정보를 공유해주시면 감사하겠습니다.
    - 본 readme.md 하단의 생성된 사이트 정보 맨 하단에 추가하셔셔 pull request 를 해주시면 됩니다.

# php extension 설치(현재 서버에 설치가 되어 있다면 단계 무시, 설치가 안되어 있을 경우 composer 패키지 설치시 에러가 날수 있음)
- sudo apt-get install openssl php-common php-curl php-json php-mbstring php-mysql php-xml php-zip

# 설치순서
- git 설치(아래 주소를 참고하여 설치)
    - https://git-scm.com/book/ko/v2/시작하기-Git-설치
- composer 설치(아래 주소를 참고하여 설치)
    - https://getcomposer.org/ 
    - https://www.lesstif.com/php-and-laravel/php-composer-23757293.html
- git clone 하여 소스 설치
- 해당 설치된 디렉토리로 이동
- composer install로 패키지 설치
- .env.example 를 .env로 복사
- .env의 내용중 'DB_XXX' 관련 내용을 사용하려는 디비 정보로 변경 
- laravel 암호화 key 생성
    - php artisan key:generate
- 디비 마이그레이트 실행
    - php artisan migrate
- 관리자 회원 정보 데이타 입력 seed 실행(회원 정보 : admin / 111111)
    - composer dump-autoload
    - php artisan db:seed

# 사이트 동작 확인 
- 서버 실행
    - php artisan serve
- 사이트 접속
    - http://localhost:8000 접속
        - 관리자
            - http://localhost:8000/admin
    
# 서비스 배포(추후 정리)
          
    
# 생성된 사이트
- ~~~    