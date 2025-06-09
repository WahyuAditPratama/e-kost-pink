package com.app.kostpink.Rest;

import com.app.kostpink.Config;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class ApiClient {

    private static String BASE_URL = Config.BASE_URL;
    private static ApiClient retrofitClient;
    private static Retrofit retrofit;

    private OkHttpClient.Builder builder = new OkHttpClient.Builder();

    private HttpLoggingInterceptor interceptor = new HttpLoggingInterceptor();


    public ApiClient() {

        Gson gson = new GsonBuilder()
                .setLenient()
                .create();
        interceptor.level(HttpLoggingInterceptor.Level.BODY);
        builder.addInterceptor(interceptor);


        retrofit = new Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .client(builder.build())
                .build();


    }


    public static synchronized ApiClient getInstance() {

        if (retrofitClient == null) {
            retrofitClient = new ApiClient();
        }
        return retrofitClient;
    }

    public ApiInterface getApi() {
        return retrofit.create(ApiInterface.class);
    }
}
