<div class="col-sm-5 col-lg-5 col-md-5">
                        <div class="reviews-content-left">
                          <div class="rating col-xs-12" style="padding: 30px 0; background-color: #b22827; margin-bottom: 5px;">
                            <span class="rating-num">
                              {{$product->getRateAvg()}}
                              <!-- {{intval($product->scopeReviewsDetails()[0]['rateAvg'])}} -->
                            </span>
                              
                            <div class="rating-stars" style="display: block;">
                              <div class="rating-stars"> 
                                @include('website.products.rating-template',[
                                  'avg'=>$product->getRateAvg()
                                ])
                              </div>
                            </div>
                            <div class="rating-users">
                              <i class="icon-user"></i> {{intval($product->scopeReviewsDetails()[0]['ratesCount'])}} {{__('Review.Total')}}
                            </div>
                          </div>
                          <h2>{{__('Product.Reviews')}}</h2>
                          @php 
                          $product_reviews = $product->get_reviews();       
                          @endphp
                          @foreach($product_reviews as $review)
                          <div class="review-ratting col-xs-12">
                            <p class="author" style="color: #b22827;font-size: 16px;"> {{ (isset($review->user)) ? $review->user->name : '' }}<span style="color: #999999; font-size: 12px;"> ({{__('Review.Posted On')}} {{$review->created_at}})</span> </p>
                            <P style="color: #333333;">{{$review->review_title}}</P>
                            <p style="color: gray;">{{$review->review}}</p>
                             <span ><div class="rating"> 
                              @include('website.products.rating-template',[
                                'stars'=>intval($review->rate)
                              ])
                            </div></span> 
                          </div>
                          @endforeach
                          
                          <!-- <div class="buttons-set">
                            <button class="button submit" title="Submit Review" type="submit"><span><i class="fa fa-angle-double-right"></i> &nbsp;view all</span></button>
                          </div> -->
                        </div>
                      </div>
                      <div class="col-sm-7 col-lg-7 col-md-7">
                      
                        <div class="reviews-content-right row ">
                        <div class="col-xs-12" style="font-size: 15px;font-weight: 600;color: black;margin: 0  0  10px 0 ;">{{__('Review.Write Your Own Review')}}</div>

                          

                          {{--  && !$product->userAlreadyReviewed --}}
                          @if(auth()->check())
                            <form action="#" method="post" id="review_form">
                              @csrf
                              <div class="table-responsive reviews-table col-xs-12">
                                <table>
                                  <tbody>
                                    <tr>
                                      <th></th>
                                      <th>1 {{__('Review.Star')}}</th>
                                      <th>2 {{__('Review.Star')}}</th>
                                      <th>3 {{__('Review.Star')}}</th>
                                      <th>4 {{__('Review.Star')}}</th>
                                      <th>5 {{__('Review.Star')}}</th>
                                    </tr>
                                    <tr>
                                      <td style="text-align: center;">{{__('Review.Rate')}}</td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="1" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="2" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="3" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="4" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="5" ></td>
                                    </tr>
                                  
                                  
                                  </tbody>
                                </table>
                              </div>


                                <div class="form-row" class="theme-form">
                                    <div class="form-area col-xs-12">
                                      <div class="form-element">
                                          <label for="review">{{trans('review.title')}}</label>
                                          <input type="text" class="form-control" name="title" id="review_title" required>
                                      </div>
                                      <div class="form-element">
                                          <label for="review">{{trans('review.body')}}</label>
                                          <textarea class="form-control" name="body" rows="6" id="review_body" required></textarea>
                                      </div>
                                      <div class="buttons-set">
                                          <button class="btn btn-normal" type="submit" id="submit_review_btn">{{trans('review.submit')}}</button>
                                      </div>
                                    </div>
                                    <input type="hidden" name="p_r_id" value="{{$p_r_id}}">
                            </form>
                        @else
                        <div class="col-xs-12" style="font-size: 15px;font-weight: 600;color: grey;text-align:center">{{__('Review.you must')}} <a href="{{url('/'.$locale.'/login')}}"  style="color: #b22827; text-decoration: underline;">{{__('Review.Login')}}</a> {{__('Review.To Write Review')}}</div>
                        @endif
                        </div>
                      </div>
                    </div>