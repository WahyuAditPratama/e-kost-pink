package com.app.kostpink.Rest;

import com.app.kostpink.model.ConfirmBookingResponse;
import com.app.kostpink.model.ConfirmTagihanResponse;
import com.app.kostpink.model.FetchBookingResponse;
import com.app.kostpink.model.FetchRoomResponse;
import com.app.kostpink.model.BookingResponse;
import com.app.kostpink.model.FetchTagihanResponse;
import com.app.kostpink.model.KonfirmasiPembayaranResponse;
import com.app.kostpink.model.LoginResponse;
import com.app.kostpink.model.LoginUserResponse;
import com.app.kostpink.model.RegisterResponse;
import com.app.kostpink.model.UpdateAvatarResponse;
import com.app.kostpink.model.UpdatePassResponse;
import com.app.kostpink.model.UpdateProfileResponse;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;
import retrofit2.http.Path;

public interface ApiInterface {

    @FormUrlEncoded
    @POST("auth/register")
    Call<RegisterResponse> register(
            @Field("nama_customer") String nama_customer,
            @Field("email") String email,
            @Field("telepon") String telepon,
            @Field("username") String username,
            @Field("password") String password

    );

    @FormUrlEncoded
    @POST("auth/login")
    Call<LoginResponse> login(
            @Field("username") String username,
            @Field("password") String password

    );

    @FormUrlEncoded
    @POST("auth/loginuser")
    Call<LoginUserResponse> loginUser(
            @Field("username") String username,
            @Field("password") String password

    );

    @FormUrlEncoded
    @POST("auth/updateprofile")
    Call<UpdateProfileResponse> updateProfile(
            @Field("id_customer") String id_customer,
            @Field("nama_customer") String nama_customer,
            @Field("email") String email,
            @Field("telepon") String telepon,
            @Field("alamat") String alamat,
            @Field("tempat_lahir") String tempat_lahir,
            @Field("tanggal_lahir") String tanggal_lahir,
            @Field("username") String username

    );

    @FormUrlEncoded
    @POST("auth/updatepassword")
    Call<UpdatePassResponse> updatePassword(
            @Field("id_customer") String id_customer,
            @Field("password") String password

    );

    @Multipart
    @POST("auth/updateavatar")
    Call<UpdateAvatarResponse> updateAvatar(
            @Part MultipartBody.Part avatar,
            @Part("id_customer") RequestBody id_customer
    );

    @GET("room/list")
    Call<FetchRoomResponse> fetchRoom();


    @GET("tagihan/list/{id_customer}")
    Call<FetchTagihanResponse> fetchTagihan(
            @Path("id_customer") String id_customer
    );

    @GET("tagihan/lunas/{id_customer}")
    Call<FetchTagihanResponse> fetchTagihanLunas(
            @Path("id_customer") String id_customer
    );

    @GET("tagihan/histori/{id_customer}")
    Call<FetchTagihanResponse> fetchTagihanHistori(
            @Path("id_customer") String id_customer
    );

    @GET("booking/list/{id_customer}")
    Call<FetchBookingResponse> fetchBooking(
            @Path("id_customer") String id_customer
    );

    @GET("booking/listadm")
    Call<FetchBookingResponse> FetchBookingAdm();

    @GET("booking/listtagihanadm")
    Call<FetchBookingResponse> FetchBookingTagihanAdm();


    @FormUrlEncoded
    @POST("booking/insert")
    Call<BookingResponse> create(
            @Field("id_customer") String id_customer,
            @Field("id_room") String id_room,
            @Field("start_date") String start_date,
            @Field("end_date") String end_date,
            @Field("harga_bulanan") String harga_bulanan,
            @Field("catatan") String catatan
            );

    @FormUrlEncoded
    @POST("booking/confirm")
    Call<ConfirmBookingResponse> confrimBooking(
            @Field("id_booking") String id_booking,
            @Field("catatan") String catatan
    );

    @FormUrlEncoded
    @POST("booking/konfirmasiadmin")
    Call<ConfirmBookingResponse> confrimBookingAdm(
            @Field("id_booking") String id_booking,
            @Field("status") String status
    );
    @Multipart
    @POST("tagihan/confirmPayment")
    Call<KonfirmasiPembayaranResponse> konfirmasiPembayaran(
            @Part MultipartBody.Part payment_proof,
            @Part("id") RequestBody id,
            @Part("payment_method") RequestBody metode_pembayaran,
            @Part("kode_voucher") RequestBody kode_voucher


    );

    @GET("tagihan/listadm/{id_customer}")
    Call<FetchTagihanResponse> fetchTagihanAdm(
            @Path("id_customer") String id_customer
    );


    @FormUrlEncoded
    @POST("tagihan/konfirmasitagihan")
    Call<ConfirmTagihanResponse> ConfrimTagihanAdm(
            @Field("id_tagihan") String id_tagihan,
            @Field("status") String status
    );

}


